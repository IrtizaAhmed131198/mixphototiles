<?php

use Illuminate\Support\Facades\Log;

function get_setting($name, $default = null)
{
    return \App\Models\Settings::where('name', $name)->value('value') ?? $default;
}

// function calculateFrameCost($quantity = 1) {

//     $delivery_cost = floatval(get_setting('delivery_cost') ?? 0);
//     $average_cost  = floatval(get_setting('average_cost') ?? 0);
//     $base_margin   = floatval(get_setting('base_margin') ?? 0);

//     // step 1: cost calculations
//     $frame_cost = $quantity * $average_cost;
//     $total_cost = $frame_cost + $delivery_cost;

//     // step 2: profit margin calculation
//     // base_margin assumed to be entered in % (e.g. 20 for 20%)
//     $profit_margin = ($base_margin / pow($quantity, 0.2)) / 100;

//     // step 3: profit per sale
//     $profit_per_sale = floor($total_cost * $profit_margin);

//     // step 4: selling price
//     $selling_price = floor($total_cost + $profit_per_sale);

//     // debug logs (optional)
//     /*
//     echo "=== Frame Cost Calculation Quantity {$quantity} ===\n";
//     echo "Delivery Cost   : {$delivery_cost}\n";
//     echo "Average Cost    : {$average_cost}\n";
//     echo "Base Margin (%) : {$base_margin}\n";
//     echo "Quantity        : {$quantity}\n";
//     echo "-------------------------------\n";
//     echo "Frame Cost      : {$frame_cost}\n";
//     echo "Total Cost      : {$total_cost}\n";
//     echo "Selling Price   : {$selling_price}\n";
//     echo "Profit per Sale : {$profit_per_sale}\n";
//     echo "Profit Margin   : {$profit_margin}\n";
//     echo "===============================\n\n";
//     */

//     return $selling_price;
// }

// function calculateFrameCost($quantity = 1) {
//     $delivery_cost = floatval(get_setting('delivery_cost') ?? 0);
//     $average_cost  = floatval(get_setting('average_cost') ?? 0);
//     $base_margin   = floatval(get_setting('base_margin') ?? 0);

//     $frame_cost = $quantity * $average_cost;

//     // Apply margin to production cost only, NOT total_cost
//     $profit_margin   = ($base_margin / pow($quantity, 0.2)) / 100;
//     $profit_per_sale = floor($frame_cost * $profit_margin);

//     // Add shipping after, as a flat pass-through
//     $selling_price = floor($frame_cost + $profit_per_sale) + $delivery_cost;

//     return $selling_price;
// }

function quantityDiscountRate(int $quantity): float
{
    if ($quantity <= 1) {
        return 0.0;
    }
    if ($quantity === 2) {
        return 0.02;
    }
    if ($quantity <= 5) {
        return 0.03;
    }
    if ($quantity <= 9) {
        return 0.05;
    }

    return 0.10;
}

/**
 * Calculate bundle price for multiple frames.
 *
 * @param  float   $subtotal    Sum of individual frame prices
 * @param  int     $n           Total number of frames
 * @param  string  $frame_type  'indian', 'european', or 'luxury_tiles'
 * @return array   [bundleTotal, perFrame, saving, discount, grandTotal]
 */
function calculateBundlePrice($subtotal, $n, $frame_type = 'european') {
    $shipping_cost = floatval(get_setting('shipping_price', 80));
    if ($frame_type === 'indian') {
        $floor_price = floatval(get_setting('indian_floor_price') ?? 295);
    } else {
        $floor_price = floatval(get_setting('floor_price') ?? 489);
    }

    if ($n <= 0 || $subtotal <= 0) {
        return ['bundleTotal' => 0, 'perFrame' => 0, 'saving' => 0, 'discount' => 0, 'grandTotal' => 0];
    }

    if ($n === 1) {
        $unitPrice = max($floor_price, $subtotal);
        return [
            'bundleTotal' => $unitPrice,
            'perFrame' => $unitPrice,
            'saving' => max(0, $subtotal - $unitPrice),
            'discount' => 0,
            'grandTotal' => $unitPrice + $shipping_cost,
        ];
    }

    $discount    = quantityDiscountRate((int) $n);
    $discounted  = $subtotal * (1 - $discount);
    $floorCheck  = $n * $floor_price;
    $bundleTotal = max($floorCheck, $discounted);

    return [
        'bundleTotal' => $bundleTotal,
        'perFrame'    => round($bundleTotal / $n, 2),
        'saving'      => round(max(0, $subtotal - $bundleTotal), 2),
        'discount'    => $discount,
        'grandTotal'  => $bundleTotal + ($n <= 2 ? $shipping_cost : 0),
    ];
}

/**
 * Get item price for the design page on load.
 * For 1 frame: returns the default size price (from settings as fallback).
 * For N frames: runs bundle formula using average size price.
 *
 * @param  int    $quantity
 * @param  float  $sizePriceOverride  Pass selected size price if known
 * @return float
 */
function calculateFrameCost($quantity = 1, $sizePriceOverride = null) {
    $delivery_cost = floatval(get_setting('shipping_price', 80));
    $average_cost  = floatval(get_setting('average_cost')  ?? 0);

    // Use size price override if provided, otherwise fall back to average_cost
    $basePrice = $sizePriceOverride > 0 ? $sizePriceOverride : $average_cost;

    if ($quantity <= 1) {
        // Single frame — return base price + delivery directly
        return $basePrice + $delivery_cost;
    }

    // Multiple frames — use bundle formula
    $subtotal = $basePrice * $quantity;
    $result   = calculateBundlePrice($subtotal, $quantity);

    return $result['grandTotal'];
}



function calculateMixedBundlePrice(array $items, ?float $discount = null, ?float $signatureFloor = null, ?float $premiumFloor = null): array {
    $discount = $discount ?? quantityDiscountRate(count($items));
    $signatureFloor = $signatureFloor ?? floatval(get_setting('indian_floor_price') ?? 295);
    $premiumFloor = $premiumFloor ?? floatval(get_setting('floor_price') ?? 489);

    if (count($items) === 0) {
        return ['bundleTotal' => 0.0, 'itemPrices' => [], 'saving' => 0.0, 'discount' => 0.0];
    }

    $appliedDiscount = $discount;
    $subtotal = 0.0;
    $itemPrices = [];

    foreach ($items as $item) {
        $price = (float) ($item['price'] ?? 0);
        $type = $item['frame_type'] ?? 'indian';
        $floor = $type === 'indian' ? $signatureFloor : $premiumFloor;
        $subtotal += $price;
        $itemPrices[] = round(max($floor, $price * (1 - $appliedDiscount)), 2);
    }

    $bundleTotal = round(array_sum($itemPrices), 2);

    return [
        'bundleTotal' => $bundleTotal,
        'itemPrices' => $itemPrices,
        'perFrame' => round($bundleTotal / count($items), 2),
        'saving' => round(max(0, $subtotal - $bundleTotal), 2),
        'discount' => $appliedDiscount,
    ];
}
function frame_collection_name(?string $type): string {
    return match ($type) {
        'european' => 'European Collection',
        'luxury_tiles' => 'Luxury Tiles',
        default => 'Signature Collection',
    };
}

function finish_display_name(?string $label): string {
    $label = (string) $label;
    $normalized = strtolower($label);
    if (str_contains($normalized, 'matte')) { return 'Rich Museum Quality Matte'; }
    if (str_contains($normalized, 'gloss')) { return 'Rich Museum Quality Glossy'; }
    return $label;
}
?>
