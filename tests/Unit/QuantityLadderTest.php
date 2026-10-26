<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class QuantityLadderTest extends TestCase
{
    public function test_excel_examples_and_shipping_boundaries(): void
    {
        foreach ([1 => 374.0, 2 => 656.24, 3 => 858.0, 6 => 1716.0, 10 => 2860.0] as $quantity => $expected) {
            $result = frameQuantityPricing([['config' => ['frame_type' => ['type' => 'indian'], 'size' => ['frameSizeText' => '8 x 8']], 'quantity' => $quantity]]);
            $this->assertSame($expected, $result['total']);
        }
        $european = frameQuantityPricing([['config' => ['frame_type' => ['type' => 'european'], 'size' => ['frameSizeText' => '8 x 11']], 'quantity' => 4]]);
        $this->assertSame(1897.32, $european['total']);
        $this->assertSame(474.33, $european['item_prices'][0]);
    }

    public function test_mixed_sizes_keep_their_individual_floors(): void
    {
        $result = frameQuantityPricing([
            ['config' => ['frame_type' => 'indian', 'size' => ['frameSizeText' => '8x8']]],
            ['config' => ['frame_type' => 'indian', 'size' => ['frameSizeText' => '12x18']]],
        ]);
        $this->assertSame([288.12, 714.42], $result['item_prices']);
        $this->assertSame(1082.54, $result['total']);
    }
}
