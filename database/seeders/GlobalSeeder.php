<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GlobalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            [
                'name' => 'delivery_cost',
                'label' => 'Delivery Cost',
                'value' => '220',
                'description' => 'Cost for delivery',
                'type' => 'number',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'average_cost',
                'label' => 'Average Production Cost',
                'value' => '320',
                'description' => 'Average Production cost of a frame without delivery fees',
                'type' => 'number',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'base_margin',
                'label' => 'Base Margin (%)',
                'value' => '20',
                'description' => 'Base margin for each frame',
                'type' => 'number',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
