<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BeneficiaryLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campaigns = \App\Models\Campaign::all();
        
        foreach ($campaigns as $campaign) {
            $locations = [
                ['campaign_id' => $campaign->id, 'location_name' => 'Cairo, Egypt',       'latitude' => 30.0444,  'longitude' => 31.2357,  'beneficiary_count' => rand(50, 150)],
                ['campaign_id' => $campaign->id, 'location_name' => 'Alexandria, Egypt',   'latitude' => 31.2001,  'longitude' => 29.9187,  'beneficiary_count' => rand(40, 100)],
                ['campaign_id' => $campaign->id, 'location_name' => 'Aswan, Egypt',        'latitude' => 24.0889,  'longitude' => 32.8998,  'beneficiary_count' => rand(30, 80)],
                ['campaign_id' => $campaign->id, 'location_name' => 'Luxor, Egypt',        'latitude' => 25.6872,  'longitude' => 32.6396,  'beneficiary_count' => rand(20, 60)],
            ];

            foreach ($locations as $location) {
                \App\Models\BeneficiaryLocation::create($location);
            }
        }
    }
}
