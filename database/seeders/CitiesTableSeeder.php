<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\State;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            'Maharashtra' => ['Mumbai', 'Pune', 'Nagpur', 'Nashik', 'Thane'],
            'Karnataka' => ['Bengaluru', 'Mysuru', 'Mangalore', 'Hubli', 'Belgaum'],
            'Delhi' => ['New Delhi', 'Dwarka', 'Rohini', 'Saket', 'Karol Bagh'],
            'Tamil Nadu' => ['Chennai', 'Coimbatore', 'Madurai', 'Tiruchirappalli', 'Salem'],
            'West Bengal' => ['Kolkata', 'Howrah', 'Durgapur', 'Asansol', 'Siliguri'],
        ];

        foreach ($cities as $stateName => $cityList) {
            $state = State::where('name', $stateName)->first();

            if ($state) {
                foreach ($cityList as $cityName) {
                    City::create([
                        'state_id' => $state->id,
                        'name' => $cityName
                    ]);
                }
            }
        }
    }
}
