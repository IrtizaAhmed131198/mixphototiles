<?php
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

function calculateFrameCost($quantity = 1) {
    $delivery_cost = floatval(get_setting('delivery_cost') ?? 0);
    $average_cost  = floatval(get_setting('average_cost') ?? 0);
    $base_margin   = floatval(get_setting('base_margin') ?? 0);

    $frame_cost = $quantity * $average_cost;

    // Apply margin to production cost only, NOT total_cost
    $profit_margin   = ($base_margin / pow($quantity, 0.2)) / 100;
    $profit_per_sale = floor($frame_cost * $profit_margin);

    // Add shipping after, as a flat pass-through
    $selling_price = floor($frame_cost + $profit_per_sale) + $delivery_cost;

    return $selling_price;
}
?>
