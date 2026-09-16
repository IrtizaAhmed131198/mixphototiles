<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
    protected function api(): Api
    {
        return new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
    }

    public function createOrder(Request $request, CheckoutService $checkout)
    {
        try {
            return Cache::lock('checkout:'.hash('sha256', $request->session()->getId()), 60)->block(5, function () use ($request, $checkout) {
                $cart = $request->session()->get('cart', []);
                $address = $request->session()->get('user_address', []);
                $coupon = $request->session()->get('applied_coupon', []);
                $fingerprint = hash('sha256', json_encode([$cart, $address, $coupon, auth()->id()]));
                $order = Order::find($request->session()->get('checkout_order_id'));
                if (! $order || $request->session()->get('checkout_fingerprint') !== $fingerprint) {
                    $order = $checkout->prepare($cart, $address, auth()->user(), $coupon);
                    $request->session()->put(['checkout_order_id' => $order->id, 'checkout_fingerprint' => $fingerprint]);
                    // Persist recovery information before making an external API call.
                    $request->session()->save();
                }
                if ($order->payment_id || $order->paid_at) {
                    return response()->json(['error' => 'A payment already exists for this checkout. Please check your order before paying again.'], 409);
                }
                $amount = (int) round($order->total_amount * 100);
                if (! $order->razorpay_order_id) {
                    $remote = $this->api()->order->create([
                        'receipt' => 'website_'.$order->id, 'amount' => $amount, 'currency' => 'INR',
                        'notes' => ['website_order_id' => (string) $order->id],
                    ]);
                    $order->razorpay_order_id = $remote['id'];
                    $order->save();
                }
                $request->session()->put('razorpay_order_id', $order->razorpay_order_id);

                return response()->json(['id' => $order->razorpay_order_id, 'amount' => $amount, 'website_order_id' => $order->id, 'customer_name' => $address['full_name'] ?? '', 'customer_email' => $address['email'] ?? '', 'customer_contact' => $address['phone_number'] ?? '']);
            });
        } catch (ValidationException $e) {
            return response()->json(['error' => collect($e->errors())->flatten()->first(), 'errors' => $e->errors()], 422);
        } catch (\Throwable $e) {
            Log::error('Checkout preparation failed', ['error' => $e->getMessage()]);

            return response()->json(['error' => 'Unable to prepare your order. Payment has not been started. Please try again.'], 503);
        }
    }

    protected function reconcile(Order $order, string $paymentId, CheckoutService $checkout): Order
    {
        return Cache::lock('payment-order:'.$order->id, 60)->block(5, function () use ($order, $paymentId, $checkout) {
            $api = $this->api();
            $payment = $api->payment->fetch($paymentId);
            // Commit the payment link and validate complete order details before capture.
            $order = $checkout->recordPayment($order, $payment->toArray());
            if ($payment['status'] === 'authorized') {
                try {
                    $payment = $payment->capture(['amount' => (int) round($order->total_amount * 100), 'currency' => 'INR']);
                } catch (\Throwable $e) {
                    // An API timeout can occur after capture. Fetch authoritative state.
                    $payment = $api->payment->fetch($paymentId);
                    if ($payment['status'] !== 'captured') {
                        throw $e;
                    }
                }
                $order = $checkout->recordPayment($order, $payment->toArray());
            }
            if (! $order->paid_at) {
                throw ValidationException::withMessages(['payment' => 'Payment capture is pending.']);
            }

            return $order;
        });
    }

    public function verifyPayment(Request $request, CheckoutService $checkout)
    {
        $request->validate([
            'razorpay_order_id' => 'required|string', 'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);
        $order = Order::find($request->session()->get('checkout_order_id'));
        if (! $order || $order->razorpay_order_id !== $request->razorpay_order_id) {
            return response()->json(['error' => 'Checkout session does not match. Please contact support before paying again.'], 409);
        }
        try {
            $this->api()->utility->verifyPaymentSignature([
                'razorpay_order_id' => $order->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);
            $order = $this->reconcile($order, $request->razorpay_payment_id, $checkout);
            $request->session()->forget(['cart', 'applied_coupon', 'gift_card_applied', 'user_address']);

            return response()->json(['success' => true, 'order_id' => $order->id, 'method' => $order->payment_method]);
        } catch (\Throwable $e) {
            Log::error('Payment confirmation failed', ['order_id' => $order->id, 'payment_id' => $request->razorpay_payment_id, 'error' => $e->getMessage()]);

            return response()->json(['error' => 'Payment confirmation is pending. Your order is saved. Please do not pay again; contact support.'], 503);
        }
    }

    public function webhook(Request $request, CheckoutService $checkout)
    {
        $secret = config('services.razorpay.webhook_secret');
        if (! $secret) {
            return response()->json(['error' => 'Webhook is not configured.'], 503);
        }
        $signature = hash_hmac('sha256', $request->getContent(), $secret);
        if (! hash_equals($signature, (string) $request->header('X-Razorpay-Signature'))) {
            return response()->json(['error' => 'Invalid signature.'], 401);
        }
        if (! in_array($request->input('event'), ['payment.authorized', 'payment.captured', 'order.paid'], true)) {
            return response()->json(['success' => true]);
        }
        $payment = $request->input('payload.payment.entity', []);
        $order = Order::where('razorpay_order_id', $payment['order_id'] ?? '')->first();
        if (! $order) {
            // Older integrations have no stored Razorpay order link.
            Log::warning('Unmatched Razorpay webhook', ['payment_id' => $payment['id'] ?? null]);

            return response()->json(['success' => true]);
        }
        try {
            $this->reconcile($order, $payment['id'], $checkout);

            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            Log::error('Payment webhook reconciliation failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);

            return response()->json(['error' => 'Please retry payment confirmation.'], 503);
        }
    }
}
