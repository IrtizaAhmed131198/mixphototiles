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

// ============================================================
// NEW BUNDLE PRICING FORMULA
// Based on: Pricing_Calculator_final.pdf
//
// Constants:
//   F      = Floor price per frame (₹599) — never sell below this
//   D_STEP = Extra discount per additional frame (5%)
//   D_MAX  = Maximum total discount allowed (20%)
//
// Formula:
//   Subtotal     = sum of individual frame prices
//   Discount     = MIN(D_MAX, D_STEP × (N − 1))
//   Discounted   = Subtotal × (1 − Discount)
//   FloorCheck   = N × F
//   BundleTotal  = MAX(FloorCheck, Discounted)
// ============================================================

define('FLOOR_PRICE', 599);   // F   — never sell below this per frame
define('D_STEP',      0.05);  // 5%  — extra discount per additional frame
define('D_MAX',       0.20);  // 20% — maximum total discount allowed

/**
 * Calculate bundle price for multiple frames.
 *
 * @param  float  $subtotal   Sum of individual frame prices
 * @param  int    $n          Total number of frames
 * @return array  [bundleTotal, perFrame, saving, discount, grandTotal]
 */
function calculateBundlePrice($subtotal, $n) {

    $delivery_cost = floatval(get_setting('delivery_cost') ?? 0);
    $floor_price   = floatval(get_setting('floor_price')   ?? 599);
    $d_step        = floatval(get_setting('d_step')        ?? 5) / 100;
    $d_max         = floatval(get_setting('d_max')         ?? 20) / 100;

    Log::info('===== Bundle Price Calculation START =====');

    Log::info('Input Values', [
        'subtotal'      => $subtotal,
        'frames (n)'    => $n,
        'delivery_cost' => $delivery_cost,
        'floor_price'   => $floor_price,
        'd_step'        => $d_step,
        'd_max'         => $d_max,
    ]);

    if ($n <= 0 || $subtotal <= 0) {
        Log::warning('Invalid input detected');

        return [
            'bundleTotal' => 0,
            'perFrame'    => 0,
            'saving'      => 0,
            'discount'    => 0,
            'grandTotal'  => $delivery_cost
        ];
    }

    if ($n === 1) {
        Log::info('Single frame — no discount applied');

        return [
            'bundleTotal' => $subtotal,
            'perFrame'    => $subtotal,
            'saving'      => 0,
            'discount'    => 0,
            'grandTotal'  => $subtotal + $delivery_cost
        ];
    }

    // Step 1: Discount
    $discount = min($d_max, $d_step * ($n - 1));
    Log::info('Calculated Discount', [
        'discount_percentage' => $discount * 100
    ]);

    // Step 2: Discounted subtotal
    $discounted = $subtotal * (1 - $discount);
    Log::info('Discounted Subtotal', [
        'discounted' => $discounted
    ]);

    // Step 3: Floor check
    $floorCheck = $n * $floor_price;
    Log::info('Floor Check Value', [
        'floorCheck' => $floorCheck
    ]);

    // Step 4: Final bundle
    $bundleTotal = max($floorCheck, $discounted);
    Log::info('Final Bundle Total', [
        'bundleTotal' => $bundleTotal
    ]);

    // Final calculations
    $perFrame   = round($bundleTotal / $n, 2);
    $saving     = round($subtotal - $bundleTotal, 2);
    $grandTotal = $bundleTotal + $delivery_cost;

    Log::info('Final Results', [
        'perFrame'   => $perFrame,
        'saving'     => $saving,
        'grandTotal' => $grandTotal
    ]);

    Log::info('===== Bundle Price Calculation END =====');

    return [
        'bundleTotal' => $bundleTotal,
        'perFrame'    => $perFrame,
        'saving'      => $saving,
        'discount'    => $discount,
        'grandTotal'  => $grandTotal,
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
    $delivery_cost = floatval(get_setting('delivery_cost') ?? 0);
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

?>
