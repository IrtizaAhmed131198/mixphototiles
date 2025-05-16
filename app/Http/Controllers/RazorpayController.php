<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Session;

class RazorpayController extends Controller
{
    public function createOrder()
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $amount = session('cart_grand_total') * 100; // In paisa
        $order = $api->order->create([
            'receipt' => uniqid(),
            'amount' => $amount,
            'currency' => 'INR'
        ]);

        session(['razorpay_order_id' => $order['id']]);
        return response()->json(['id' => $order['id'], 'amount' => $amount]);
    }

    public function verifyPayment(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        ];

        try {
            $api->utility->verifyPaymentSignature($attributes);

            // Payment is verified — now place the order
            // return app(OrderController::class)->place_order($request->merge([
            //     'payment_method' => 'razorpay',
            //     'razorpay_payment_id' => $request->razorpay_payment_id
            // ]));
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Payment verification failed.'], 500);
        }
    }
}
