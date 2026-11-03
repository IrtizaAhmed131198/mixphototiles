<?php

namespace App\Services;

use App\Models\CheckoutEvent;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class CheckoutTracking
{
    public static function record(Order $order, string $event, string $source = 'server', ?string $code = null): void
    {
        try {
            CheckoutEvent::create(['order_id' => $order->id, 'event' => $event, 'source' => $source, 'error_code' => $code]);
        } catch (\Throwable $error) {
            // Diagnostics must never prevent checkout or confirmation.
            Log::warning('Checkout tracking unavailable', ['order_id' => $order->id, 'event' => $event]);
        }
    }
}
