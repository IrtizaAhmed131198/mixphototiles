<?php

namespace App\Services;

use App\Mail\OrderPlacedAdminMail;
use App\Mail\OrderPlacedUserMail;
use App\Mail\OtpMail;
use App\Models\Address;
use App\Models\City;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\ShippingAddress;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CheckoutService
{
    public function totals(array $cart, array $coupon = []): array
    {
        Validator::make(['cart' => $cart], [
            'cart' => 'required|array|min:1',
            'cart.*.product_id' => 'required|integer|exists:products,id',
            'cart.*.quantity' => 'required|integer|min:1|max:100',
        ])->validate();
        $subtotal = 0;
        foreach ($cart as $item) {
            $product = Product::findOrFail($item['product_id']);
            if ((float) $product->price <= 0 || (int) $product->status !== 1) {
                throw ValidationException::withMessages(['cart' => 'A cart product is unavailable.']);
            }
            $subtotal += (float) $product->price * $item['quantity'];
        }
        $discount = 0;
        $code = $coupon['code'] ?? null;
        if ($code) {
            $record = Coupon::where('code', $code)->where('status', 1)->first();
            if (! $record) {
                throw ValidationException::withMessages(['coupon' => 'Please remove the invalid coupon.']);
            }
            $discount = (float) $record->discount_amount;
        }
        $shipping = max(0, (float) get_setting('shipping_price', 0));
        $total = round(round($subtotal) + $shipping - $discount);
        if ($total <= 0) {
            throw ValidationException::withMessages(['cart' => 'The checkout total must be positive.']);
        }

        return compact('subtotal', 'shipping', 'discount', 'code', 'total');
    }

    public function prepare(array $cart, array $address, ?User $customer, array $coupon = []): Order
    {
        Validator::make($address, [
            'full_name' => 'required|string|max:255', 'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:255', 'pincode' => 'required|digits:6',
            'address_line1' => 'required|string', 'city' => 'required|exists:cities,id',
            'state' => 'required|exists:states,id',
        ])->validate();
        if (! $customer) {
            Validator::make($address, [
                'email' => 'unique:users,email', 'password' => 'required|string|min:6',
            ])->validate();
        }

        return DB::transaction(function () use ($cart, $address, $customer, $coupon) {
            $totals = $this->totals($cart, $coupon);
            $city = City::whereKey($address['city'])->where('state_id', $address['state'])->first();
            if (! $city) {
                throw ValidationException::withMessages(['city' => 'Choose a city in the selected state.']);
            }
            if (! $customer) {
                $customer = User::create([
                    'name' => $address['full_name'], 'email' => $address['email'],
                    'phone' => $address['phone_number'], 'password' => $address['password'],
                    'role' => 'user', 'status' => 0,
                ]);
                $customer->otp = random_int(100000, 999999);
                $customer->otp_expires_at = now()->addMinutes(10);
                $customer->save();
                DB::afterCommit(function () use ($customer) {
                    try {
                        Mail::to($customer->email)->send(new OtpMail($customer->otp, $customer->name));
                    } catch (\Throwable $e) {
                        Log::warning('Checkout OTP email failed', ['user_id' => $customer->id]);
                    }
                });
            }
            $order = new Order;
            $order->user_id = $customer->id;
            $order->status = 'pending';
            $order->payment_method = 'razorpay';
            $order->total_amount = $totals['total'];
            $order->coupon = $totals['code'];
            $order->discount = $totals['discount'];
            $order->shipping = $totals['shipping'];
            $order->gift = 0;
            $order->save();
            Address::create([
                'order_id' => $order->id, 'user_id' => $customer->id,
                'full_name' => $address['full_name'], 'email' => $address['email'],
                'phone_number' => $address['phone_number'], 'pincode' => $address['pincode'],
                'address_line1' => $address['address_line1'], 'address_line2' => $address['address_line2'] ?? null,
                'city' => $city->name, 'alternate_phone_number' => $address['alternate_phone_number'] ?? null,
            ]);
            foreach ($cart as $entry) {
                $item = new OrderItems;
                $item->order_id = $order->id;
                $item->product_id = $entry['product_id'];
                $item->quantity = $entry['quantity'];
                $item->price = Product::findOrFail($entry['product_id'])->price;
                $item->save();
            }
            ShippingAddress::where('user_id', $customer->id)->update(['default_address' => 0]);
            ShippingAddress::updateOrCreate(['user_id' => $customer->id, 'email' => $address['email']], [
                'recipient_name' => $address['full_name'], 'phone' => $address['phone_number'],
                'pin_code' => $address['pincode'], 'address_line1' => $address['address_line1'],
                'address_line2' => $address['address_line2'] ?? null, 'city' => $address['city'],
                'state' => $address['state'], 'alt_phone' => $address['alternate_phone_number'] ?? null,
                'default_address' => 1,
            ]);

            return $order;
        });
    }

    public function recordPayment(Order $order, array $payment): Order
    {
        return DB::transaction(function () use ($order, $payment) {
            $order = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();
            if (! $order->razorpay_order_id || ($payment['order_id'] ?? null) !== $order->razorpay_order_id
                || ($payment['currency'] ?? null) !== 'INR'
                || (int) ($payment['amount'] ?? 0) !== (int) round($order->total_amount * 100)
                || ! in_array($payment['status'] ?? null, ['authorized', 'captured'], true)
                || empty($payment['id'])) {
                throw ValidationException::withMessages(['payment' => 'Payment does not match this saved order.']);
            }
            if (! $order->address || ! $order->orderItems()->exists()) {
                throw ValidationException::withMessages(['payment' => 'Order details are incomplete. Payment will not be captured.']);
            }
            if ($order->payment_id && $order->payment_id !== $payment['id']) {
                throw ValidationException::withMessages(['payment' => 'This order already has another payment.']);
            }
            $newlyPaid = ! $order->paid_at && $payment['status'] === 'captured';
            $order->payment_id = $payment['id'];
            $order->payment_method = $payment['method'] ?? 'razorpay';
            if ($newlyPaid) {
                $order->status = 'ordered';
                $order->paid_at = now();
            }
            $order->save();
            if ($newlyPaid) {
                DB::afterCommit(function () use ($order) {
                    try {
                        $order->load(['orderItems.product', 'user', 'address']);
                        Mail::to($order->user->email)->send(new OrderPlacedUserMail($order));
                        $email = get_setting('contact_email', config('mail.from.address'));
                        if ($email) {
                            Mail::to($email)->send(new OrderPlacedAdminMail($order));
                        }
                    } catch (\Throwable $e) {
                        Log::warning('Paid order email failed', ['order_id' => $order->id]);
                    }
                });
            }

            return $order;
        });
    }
}
