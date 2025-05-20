<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\BadRequestError;
use Illuminate\Support\Facades\Session;

class RazorpayController extends Controller
{
    public function createOrder()
    {
        try {
            $cartTotal = session('cart_grand_total');

            $amount = (float)$cartTotal * 100;

            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $order = $api->order->create([
                'receipt' => uniqid(),
                'amount' => $amount,
                'currency' => 'INR'
            ]);

            session(['razorpay_order_id' => $order['id']]);

            return response()->json(['id' => $order['id'], 'amount' => $amount]);

        } catch (\Razorpay\Api\Errors\BadRequestError $e) {
            return response()->json(['error' => 'Bad request: ' . $e->getMessage()], 400);
        } catch (\Razorpay\Api\Errors\ServerError $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'General error: ' . $e->getMessage()], 500);
        }
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

            // Fetch full payment details
            $payment = $api->payment->fetch($request->razorpay_payment_id);
            $method = $payment->method;  // <-- Get the method of payment here (upi, card, etc.)

            return response()->json([
                'success' => true,
                'method' => $method,
                'payment' => $payment->toArray() // You can return full details if needed
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Payment verification failed.'], 500);
        }
    }

}
