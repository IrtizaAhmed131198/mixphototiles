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
        ], 0.05, 295, 489);

        $this->assertSame(784.0, $result['bundleTotal']);
        $this->assertSame([295.0, 489.0], $result['itemPrices']);
    }
}