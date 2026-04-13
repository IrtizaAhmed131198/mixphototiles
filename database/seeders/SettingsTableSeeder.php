<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->truncate(); // optional: clears existing data

        DB::table('settings')->insert([
            [
                'id' => 1,
                'name' => 'site_name',
                'label' => 'Site Name',
                'value' => 'Magentick Photo Frames',
                'description' => 'The name of the website',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'site_logo',
                'label' => 'Site Logo',
                'value' => null,
                'description' => "Logo of the website\n",
                'type' => 'file',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'maintenance_mode',
                'label' => 'Maintenance Mode',
                'value' => '1',
                'description' => "1 for ON, 0 for OFF\n",
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'contact_email',
                'label' => 'Contact Email',
                'value' => 'help@magentickphotoframes.com',
                'description' => "Email address for contact\n",
                'type' => 'email',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'facebook',
                'label' => 'Facebook Link',
                'value' => null,
                'description' => 'Facebook link',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'name' => 'instagram',
                'label' => 'Instagram Link',
                'value' => null,
                'description' => 'Instagram link',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'name' => 'twitter',
                'label' => 'Twitter Link',
                'value' => null,
                'description' => 'Twitter Link',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'name' => 'led',
                'label' => 'LED',
                'value' => '0',
                'description' => '1 for ON, 0 for OFF',
                'type' => 'number',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'name' => 'finish',
                'label' => 'Finish',
                'value' => '0',
                'description' => '1 for ON, 0 for OFF',
                'type' => 'number',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'name' => 'floor_price',
                'label' => 'Flooer Price',
                'value' => '599',
                'description' => 'Enter floor price',
                'type' => 'number',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 11,
                'name' => 'd_step',
                'label' => 'D Step',
                'value' => '5',
                'description' => 'Enter D Step',
                'type' => 'number',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 12,
                'name' => 'd_max',
                'label' => 'D Max',
                'value' => '20',
                'description' => 'Enter D Max',
                'type' => 'number',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
