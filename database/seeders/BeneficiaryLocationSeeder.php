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
        $campaign = \App\Models\Campaign::first();
        
        if (!$campaign) return;

        $locations = [
            ['campaign_id' => $campaign->id, 'location_name' => 'Cairo, Egypt',       'latitude' => 30.0444,  'longitude' => 31.2357,  'beneficiary_count' => 120],
            ['campaign_id' => $campaign->id, 'location_name' => 'Alexandria, Egypt',   'latitude' => 31.2001,  'longitude' => 29.9187,  'beneficiary_count' => 85],
            ['campaign_id' => $campaign->id, 'location_name' => 'Aswan, Egypt',        'latitude' => 24.0889,  'longitude' => 32.8998,  'beneficiary_count' => 60],
            ['campaign_id' => $campaign->id, 'location_name' => 'Luxor, Egypt',        'latitude' => 25.6872,  'longitude' => 32.6396,  'beneficiary_count' => 45],
        ];

        foreach ($locations as $location) {
            \App\Models\BeneficiaryLocation::create($location);
        }
    }
}
