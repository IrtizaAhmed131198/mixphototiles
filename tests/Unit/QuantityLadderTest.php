<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class QuantityLadderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite');
        Schema::create('settings', function (Blueprint $table) { $table->string('name'); $table->string('value'); });
        Schema::create('sizes', function (Blueprint $table) {
            $table->id(); $table->string('label'); $table->string('frame_type'); $table->decimal('price', 10, 2); $table->integer('status');
            $table->string('width')->default('300'); $table->string('height')->default('360');
        });
        DB::table('settings')->insert([['name' => 'indian_floor_price', 'value' => '295'], ['name' => 'floor_price', 'value' => '489']]);
        DB::table('sizes')->insert([
            ['label' => '6" X 8"', 'frame_type' => 'indian', 'price' => 299, 'status' => 1],
            ['label' => '12x15', 'frame_type' => 'indian', 'price' => 649, 'status' => 1],
            ['label' => '8x11', 'frame_type' => 'european', 'price' => 559, 'status' => 1],
        ]);
    }
    public function test_excel_examples_and_shipping_boundaries(): void
    {
        foreach ([1 => 379.0, 2 => 670.0, 3 => 885.0, 6 => 1770.0, 10 => 2950.0] as $quantity => $expected) {
            $result = frameQuantityPricing([['config' => ['frame_type' => ['type' => 'indian'], 'size' => ['frameSizeText' => '6 x 8']], 'quantity' => $quantity]]);
            $this->assertSame($expected, $result['total']);
        }
        $european = frameQuantityPricing([['config' => ['frame_type' => ['type' => 'european'], 'size' => ['frameSizeText' => '8 x 11']], 'quantity' => 4]]);
        $this->assertSame(2168.92, $european['total']);
        $this->assertSame(542.23, $european['item_prices'][0]);
    }

    public function test_mixed_sizes_keep_their_individual_floors(): void
    {
        $result = frameQuantityPricing([
            ['config' => ['frame_type' => 'indian', 'size' => ['frameSizeText' => '6x8']]],
            ['config' => ['frame_type' => 'indian', 'size' => ['frameSizeText' => '12x15']]],
        ]);
        $this->assertSame([295.0, 636.02], $result['item_prices']);
        $this->assertSame(1011.02, $result['total']);
    }

    public function test_new_size_and_updated_admin_price_are_used_without_code_changes(): void
    {
        DB::table('sizes')->insert(['label' => '9x13', 'frame_type' => 'indian', 'price' => 500, 'status' => 1]);
        $entries = [['config' => ['frame_type' => 'indian', 'size' => ['frameSizeText' => '9x13', 'frame_price' => 1]], 'quantity' => 2]];
        $this->assertSame(1060.0, frameQuantityPricing($entries)['total']);
        DB::table('sizes')->where('label', '9x13')->update(['price' => 600]);
        $this->assertSame(1256.0, frameQuantityPricing($entries)['total']);
        DB::table('settings')->where('name', 'indian_floor_price')->update(['value' => 595]);
        $this->assertSame(1270.0, frameQuantityPricing($entries)['total']);
    }

    public function test_collection_switch_recovers_mismatched_and_legacy_sizes(): void
    {
        $config = normalizeDesignerConfiguration(['frame_type' => ['type' => 'european'], 'size' => ['frameSizeText' => '6x8']]);
        $this->assertSame('8x11', $config['size']['frameSizeText']);
        $this->assertSame(559.0, frameQuantityPricing([['config' => $config]])['subtotal']);
        $config['frame_type'] = ['type' => 'indian'];
        $config = normalizeDesignerConfiguration($config);
        $this->assertSame('6" X 8"', $config['size']['frameSizeText']);
        $this->assertSame(299.0, frameQuantityPricing([['config' => $config]])['subtotal']);
        $legacy = normalizeDesignerConfiguration(['size' => ['frameSizeText' => '6x8']]);
        $this->assertSame('indian', $legacy['frame_type']['type']);
    }
}
