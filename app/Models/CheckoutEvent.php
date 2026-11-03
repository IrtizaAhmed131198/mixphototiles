<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckoutEvent extends Model
{
    protected $guarded = [];

    public function getLabelAttribute(): string
    {
        return [
            'order_prepared' => 'Website order saved — awaiting Razorpay order',
            'gateway_order_failed' => 'Server could not create Razorpay order',
            'order_created' => 'Payment pending — Razorpay order created',
            'popup_open_requested' => 'Browser requested payment popup',
            'popup_closed' => 'Browser reported checkout closed',
            'popup_open_failed' => 'Browser could not open payment popup',
            'payment_failed' => 'Browser reported payment failure',
            'payment_callback_received' => 'Browser received payment response — awaiting verification',
            'confirmation_pending' => 'Browser could not confirm payment',
            'payment_verified' => 'Payment verified by server',
        ][$this->event] ?? $this->event;
    }
}
