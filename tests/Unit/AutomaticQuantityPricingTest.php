<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class AutomaticQuantityPricingTest extends TestCase
{
    public function test_quantity_discount_uses_every_tier_boundary(): void
    {
        $this->assertSame(0.0, quantityDiscountRate(1));
        $this->assertSame(0.02, quantityDiscountRate(2));
        $this->assertSame(0.03, quantityDiscountRate(3));
        $this->assertSame(0.03, quantityDiscountRate(5));
        $this->assertSame(0.05, quantityDiscountRate(6));
        $this->assertSame(0.05, quantityDiscountRate(9));
        $this->assertSame(0.10, quantityDiscountRate(10));
        $this->assertSame(0.10, quantityDiscountRate(25));
    }

    public function test_indian_and_european_discounts_are_independent(): void
    {
        $result = calculateAutomaticQuantityPricing([
            framePricingDetails('indian', '8" X 8"'),
            framePricingDetails('indian', '8" X 8"'),
            framePricingDetails('european', '8" X 8"'),
            framePricingDetails('european', '8" X 8"'),
        ]);

        $this->assertSame(0.02, $result['categories']['indian']['discount']);
        $this->assertSame(0.02, $result['categories']['european']['discount']);
        $this->assertSame([293.02, 293.02, 409.64, 409.64], $result['items']);
    }

    public function test_three_signature_and_two_european_items_get_separate_tiers(): void
    {
        $result = calculateAutomaticQuantityPricing([
            framePricingDetails('indian', '8" X 8"'),
            framePricingDetails('indian', '8" X 8"'),
            framePricingDetails('indian', '8" X 8"'),
            framePricingDetails('european', '8" X 8"'),
            framePricingDetails('european', '8" X 8"'),
        ]);

        $this->assertSame(0.03, $result['categories']['indian']['discount']);
        $this->assertSame(0.02, $result['categories']['european']['discount']);
        $this->assertSame([290.03, 290.03, 290.03, 409.64, 409.64], $result['items']);
        $this->assertSame(870.09, $result['categories']['indian']['bundle_total']);
        $this->assertSame(819.28, $result['categories']['european']['bundle_total']);
    }

    public function test_single_item_in_each_category_receives_no_discount(): void
    {
        $result = calculateAutomaticQuantityPricing([
            framePricingDetails('indian', '8" X 8"'),
            framePricingDetails('european', '8" X 8"'),
        ]);

        $this->assertSame(0.0, $result['categories']['indian']['discount']);
        $this->assertSame(0.0, $result['categories']['european']['discount']);
        $this->assertSame([299.0, 418.0], $result['items']);
        $this->assertSame(0.0, $result['product_savings']);
    }

    public function test_luxury_tiles_share_european_quantity_tiers(): void
    {
        $result = calculateAutomaticQuantityPricing([
            framePricingDetails('european', '8" X 8"'),
            framePricingDetails('luxury_tiles', '8.4" X 8.4"'),
        ]);

        $this->assertSame(0.02, $result['categories']['european']['discount']);
        $this->assertSame([409.64, 409.64], $result['items']);
        $this->assertSame(819.28, $result['bundle_total']);
        $this->assertSame(16.72, $result['product_savings']);
    }

    public function test_every_listed_size_uses_its_retail_cost_and_floor_values(): void
    {
        $expected = [
            ['indian', '8x8', 299.0, 186.0, 272.0],
            ['indian', '8x12', 349.0, 206.0, 329.0],
            ['indian', '12x15', 599.0, 291.0, 569.0],
            ['indian', '12x18', 649.0, 321.0, 629.0],
            ['european', '8x8', 418.0, 255.0, 379.0],
            ['european', '8x11', 489.0, 292.0, 459.0],
            ['european', '12x12', 799.0, 412.0, 739.0],
            ['luxury_tiles', '8.4x8.4', 418.0, 282.0, 378.0],
        ];

        foreach ($expected as [$type, $size, $retail, $cost, $floor]) {
            $details = framePricingDetails($type, $size);
            $this->assertSame($retail, $details['retail_price']);
            $this->assertSame($cost, $details['production_cost']);
            $this->assertSame($floor, $details['minimum_floor']);
        }
    }

    public function test_indian_two_item_example_matches_unit_price_savings_and_margin(): void
    {
        $result = calculateAutomaticQuantityPricing([
            framePricingDetails('indian', '8" X 8"'),
            framePricingDetails('indian', '8" X 8"'),
        ]);

        $this->assertSame([293.02, 293.02], $result['items']);
        $this->assertSame(598.0, $result['regular_total']);
        $this->assertSame(586.04, $result['bundle_total']);
        $this->assertSame(11.96, $result['product_savings']);
        $this->assertSame(214.04, $result['profit']);
        $this->assertSame(36.5, $result['profit_margin']);
        $this->assertTrue($result['margin_protected']);
    }

    public function test_minimum_floor_caps_discount_without_creating_false_savings(): void
    {
        $items = array_fill(0, 10, framePricingDetails('indian', '8" X 8"'));
        $result = calculateAutomaticQuantityPricing($items);

        $this->assertSame(0.10, $result['categories']['indian']['discount']);
        $this->assertSame(2720.0, $result['bundle_total']);
        $this->assertSame(270.0, $result['product_savings']);
        $this->assertSame(31.6, $result['profit_margin']);
    }

    public function test_shipping_is_eighty_for_one_or_two_items_and_free_from_three(): void
    {
        $this->assertSame(80.0, quantityShippingCharge(1));
        $this->assertSame(80.0, quantityShippingCharge(2));
        $this->assertSame(0.0, quantityShippingCharge(3));
    }

    public function test_margin_is_not_claimed_when_a_selected_addon_cost_is_unknown(): void
    {
        $result = calculateAutomaticQuantityPricing([
            framePricingDetails('european', '8" X 8"', null, 40, true),
        ]);

        $this->assertNull($result['profit']);
        $this->assertNull($result['profit_margin']);
        $this->assertNull($result['margin_protected']);
    }

    public function test_next_tier_message_reports_remaining_items_and_rate(): void
    {
        $this->assertSame(['quantity' => 3, 'discount' => 0.03, 'remaining' => 1], nextQuantityTier(2));
        $this->assertSame(['quantity' => 6, 'discount' => 0.05, 'remaining' => 1], nextQuantityTier(5));
        $this->assertSame(['quantity' => null, 'discount' => null, 'remaining' => 0], nextQuantityTier(10));
    }
}
