<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PricingSettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            [
                'name'        => 'floor_price',
                'label'       => 'Floor Price',
                'value'       => '599',
                'description' => 'Enter floor price',
                'type'        => 'number',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'd_step',
                'label'       => 'D Step',
                'value'       => '5',
                'description' => 'Enter D Step',
                'type'        => 'number',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'd_max',
                'label'       => 'D Max',
                'value'       => '20',
                'description' => 'Enter D Max',
                'type'        => 'number',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['name' => $setting['name']],
                $setting
            );
        }
    }
}
