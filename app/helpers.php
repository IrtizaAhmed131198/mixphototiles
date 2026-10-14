<?php

use Illuminate\Support\Facades\Log;

function get_setting($name, $default = null)
{
    return \App\Models\Settings::where('name', $name)->value('value') ?? $default;
}

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

function framePricingCatalog(): array
{
    return [
        'indian' => [
            '8x8' => ['retail_price' => 299.0, 'production_cost' => 186.0, 'minimum_floor' => 272.0],
            '8x12' => ['retail_price' => 349.0, 'production_cost' => 206.0, 'minimum_floor' => 329.0],
            '12x15' => ['retail_price' => 599.0, 'production_cost' => 291.0, 'minimum_floor' => 569.0],
            '12x18' => ['retail_price' => 649.0, 'production_cost' => 321.0, 'minimum_floor' => 629.0],
        ],
        'european' => [
            '8x8' => ['retail_price' => 418.0, 'production_cost' => 255.0, 'minimum_floor' => 379.0],
            '8x11' => ['retail_price' => 489.0, 'production_cost' => 292.0, 'minimum_floor' => 459.0],
            '12x12' => ['retail_price' => 799.0, 'production_cost' => 412.0, 'minimum_floor' => 739.0],
        ],
        'luxury_tiles' => [
            '8.4x8.4' => ['retail_price' => 418.0, 'production_cost' => 282.0, 'minimum_floor' => 378.0],
        ],
    ];
}

function normalizeFrameSizeLabel(?string $label): string
{
    preg_match_all('/\d+(?:\.\d+)?/', strtolower((string) $label), $dimensions);

    return implode('x', $dimensions[0]);
}

function framePricingDetails(
    ?string $frameType,
    ?string $sizeLabel,
    ?float $fallbackRetailPrice = null,
    float $addonRetailPrice = 0.0,
    bool $hasUncostedAddons = false
): array {
    $frameType = strtolower((string) $frameType);
    $category = match ($frameType) {
        'european', 'luxury_tiles' => 'european',
        'indian' => 'indian',
        default => 'unclassified',
    };
    $sizeKey = normalizeFrameSizeLabel($sizeLabel);
    $catalogEntry = framePricingCatalog()[$frameType][$sizeKey] ?? null;
    $retailPrice = $catalogEntry['retail_price'] ?? $fallbackRetailPrice;
    $floor = $catalogEntry['minimum_floor'] ?? null;

    if ($retailPrice === null) {
        $retailPrice = 0.0;
    }

    if (!$catalogEntry && $category !== 'unclassified') {
        $floorSetting = $category === 'indian' ? 'indian_floor_price' : 'floor_price';
        $floor = (float) get_setting($floorSetting, 0);
    }

    return [
        'frame_type' => $frameType ?: 'unclassified',
        'category' => $category,
        'size' => $sizeKey,
        'retail_price' => round((float) $retailPrice + $addonRetailPrice, 2),
        'production_cost' => $catalogEntry['production_cost'] ?? null,
        'minimum_floor' => $floor === null ? null : round((float) $floor + $addonRetailPrice, 2),
        'cost_known' => $catalogEntry !== null && !$hasUncostedAddons,
        'uncosted_addons' => $hasUncostedAddons,
    ];
}

function nextQuantityTier(int $quantity): array
{
    foreach ([2, 3, 6, 10] as $threshold) {
        if ($quantity < $threshold) {
            return [
                'quantity' => $threshold,
                'discount' => quantityDiscountRate($threshold),
                'remaining' => $threshold - $quantity,
            ];
        }
    }

    return ['quantity' => null, 'discount' => null, 'remaining' => 0];
}

function quantityShippingCharge(int $quantity): float
{
    return $quantity >= 3 ? 0.0 : 80.0;
}

function calculateAutomaticQuantityPricing(array $items): array
{
    $categoryQuantities = [];
    foreach ($items as $item) {
        $category = $item['category'] ?? 'unclassified';
        $categoryQuantities[$category] = ($categoryQuantities[$category] ?? 0) + 1;
    }

    $categoryDiscounts = [];
    foreach ($categoryQuantities as $category => $quantity) {
        $categoryDiscounts[$category] = $category === 'unclassified' ? 0.0 : quantityDiscountRate($quantity);
    }

    $itemPrices = [];
    $categories = [];
    foreach ($items as $index => $item) {
        $category = $item['category'] ?? 'unclassified';
        $discount = $categoryDiscounts[$category] ?? 0.0;
        $retail = (float) ($item['retail_price'] ?? 0);
        $floor = $item['minimum_floor'] ?? null;
        $price = $retail * (1 - $discount);
        if ($floor !== null) {
            $price = max((float) $floor, $price);
        }
        $price = round($price, 2);
        $itemPrices[$index] = $price;

        if (!isset($categories[$category])) {
            $categories[$category] = [
                'quantity' => $categoryQuantities[$category],
                'discount' => $discount,
                'regular_total' => 0.0,
                'bundle_total' => 0.0,
                'product_savings' => 0.0,
                'production_cost' => 0.0,
                'cost_known' => true,
                'has_uncosted_addons' => false,
            ];
        }

        $categories[$category]['regular_total'] += $retail;
        $categories[$category]['bundle_total'] += $price;
        $categories[$category]['has_uncosted_addons'] =
            $categories[$category]['has_uncosted_addons'] || (bool) ($item['uncosted_addons'] ?? false);
        if (!($item['cost_known'] ?? false) || !isset($item['production_cost'])) {
            $categories[$category]['cost_known'] = false;
        } else {
            $categories[$category]['production_cost'] += (float) $item['production_cost'];
        }
    }

    $regularTotal = 0.0;
    $bundleTotal = 0.0;
    $productionCost = 0.0;
    $allCostsKnown = true;
    foreach ($categories as $category => &$summary) {
        $summary['regular_total'] = round($summary['regular_total'], 2);
        $summary['bundle_total'] = round($summary['bundle_total'], 2);
        $summary['product_savings'] = round(max(0, $summary['regular_total'] - $summary['bundle_total']), 2);
        $summary['next_tier'] = nextQuantityTier($summary['quantity']);
        $summary['profit'] = null;
        $summary['profit_margin'] = null;
        $summary['margin_protected'] = null;
        if ($summary['cost_known']) {
            $summary['production_cost'] = round($summary['production_cost'], 2);
            $summary['profit'] = round($summary['bundle_total'] - $summary['production_cost'], 2);
            $summary['profit_margin'] = $summary['bundle_total'] > 0
                ? round(($summary['profit'] / $summary['bundle_total']) * 100, 1)
                : 0.0;
            $summary['margin_protected'] = $summary['profit_margin'] >= 28.0;
            $productionCost += $summary['production_cost'];
        } else {
            $allCostsKnown = false;
            $summary['production_cost'] = null;
        }
        $regularTotal += $summary['regular_total'];
        $bundleTotal += $summary['bundle_total'];
    }
    unset($summary);

    $bundleTotal = round($bundleTotal, 2);
    $regularTotal = round($regularTotal, 2);
    $productSavings = round(max(0, $regularTotal - $bundleTotal), 2);
    $profit = $allCostsKnown ? round($bundleTotal - $productionCost, 2) : null;
    $profitMargin = $allCostsKnown && $bundleTotal > 0
        ? round(($profit / $bundleTotal) * 100, 1)
        : null;

    return [
        'items' => $itemPrices,
        'categories' => $categories,
        'quantity' => count($items),
        'regular_total' => $regularTotal,
        'bundle_total' => $bundleTotal,
        'product_savings' => $productSavings,
        'production_cost' => $allCostsKnown ? round($productionCost, 2) : null,
        'profit' => $profit,
        'profit_margin' => $profitMargin,
        'margin_protected' => $profitMargin === null ? null : $profitMargin >= 28.0,
        'all_costs_known' => $allCostsKnown,
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
