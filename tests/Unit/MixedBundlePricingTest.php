<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class MixedBundlePricingTest extends TestCase
{
    public function test_mixed_collections_keep_their_own_floor_prices(): void
    {
        $result = calculateMixedBundlePrice([
            ['price' => 299, 'frame_type' => 'indian'],
            ['price' => 489, 'frame_type' => 'european'],
        ], null, 295, 489);

        $this->assertSame(0.02, $result['discount']);
        $this->assertSame(784.0, $result['bundleTotal']);
        $this->assertSame([295.0, 489.0], $result['itemPrices']);
    }

    public function test_quantity_discount_uses_the_configured_ladder(): void
    {
        $this->assertSame(0.0, quantityDiscountRate(1));
        $this->assertSame(0.02, quantityDiscountRate(2));
        $this->assertSame(0.03, quantityDiscountRate(3));
        $this->assertSame(0.03, quantityDiscountRate(5));
        $this->assertSame(0.05, quantityDiscountRate(6));
        $this->assertSame(0.05, quantityDiscountRate(9));
        $this->assertSame(0.10, quantityDiscountRate(10));
    }

    public function test_indian_frames_use_the_quantity_ladder_and_indian_floor(): void
    {
        $result = calculateMixedBundlePrice([
            ['price' => 279, 'frame_type' => 'indian'],
            ['price' => 279, 'frame_type' => 'indian'],
        ], null, 272, 489);

        $this->assertSame(0.02, $result['discount']);
        $this->assertSame([273.42, 273.42], $result['itemPrices']);
        $this->assertSame(546.84, $result['bundleTotal']);
        $this->assertSame(11.16, $result['saving']);
    }

    public function test_luxury_tiles_use_the_european_tier_and_floor(): void
    {
        $result = calculateMixedBundlePrice([
            ['price' => 500, 'frame_type' => 'european'],
            ['price' => 500, 'frame_type' => 'luxury_tiles'],
        ], null, 295, 489);

        $this->assertSame(0.02, $result['discount']);
        $this->assertSame([490.0, 490.0], $result['itemPrices']);
        $this->assertSame(980.0, $result['bundleTotal']);
    }

    public function test_discounted_item_price_never_falls_below_its_collection_floor(): void
    {
        $result = calculateMixedBundlePrice([
            ['price' => 490, 'frame_type' => 'luxury_tiles'],
            ['price' => 490, 'frame_type' => 'european'],
        ], null, 295, 489);

        $this->assertSame([489.0, 489.0], $result['itemPrices']);
        $this->assertSame(978.0, $result['bundleTotal']);
    }
}