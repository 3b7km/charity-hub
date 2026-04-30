<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$campaigns = \App\Models\Campaign::all();

// 1. LOCATIONS
$egyptLocations = [
    ['name' => '10th of Ramadan - Industrial Zone',   'lat' => 30.2957, 'lng' => 31.7622],
    ['name' => '10th of Ramadan - District 1',        'lat' => 30.3010, 'lng' => 31.7580],
    ['name' => '10th of Ramadan - Youth Center',      'lat' => 30.2890, 'lng' => 31.7700],
    ['name' => '10th of Ramadan - Community School',   'lat' => 30.3050, 'lng' => 31.7550],
];

\App\Models\BeneficiaryLocation::query()->delete();

$i = 0;
foreach ($campaigns as $campaign) {
    $loc1 = $egyptLocations[$i % count($egyptLocations)];
    $loc2 = $egyptLocations[($i + 1) % count($egyptLocations)];

    \App\Models\BeneficiaryLocation::create([
        'campaign_id' => $campaign->id,
        'location_name' => $loc1['name'],
        'latitude' => $loc1['lat'],
        'longitude' => $loc1['lng'],
        'beneficiary_count' => rand(100, 800),
        'notes' => 'Primary beneficiary site.',
    ]);

    \App\Models\BeneficiaryLocation::create([
        'campaign_id' => $campaign->id,
        'location_name' => $loc2['name'],
        'latitude' => $loc2['lat'],
        'longitude' => $loc2['lng'],
        'beneficiary_count' => rand(30, 200),
        'notes' => 'Secondary outreach point.',
    ]);

    $i += 2;
}

// 2. PHOTOS
$photos = [
    'Clean Water Initiative' => 'https://jp.church.mt/wp-content/uploads/2020/04/gua-maos-mrjn-Photography-on-Unsplash.jpg',
    'Education for All' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=800&q=80',
    'Emergency Disaster Relief' => 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?w=800&q=80',
];

foreach ($photos as $title => $url) {
    $c = \App\Models\Campaign::where('title', $title)->first();
    if ($c) {
        $filename = 'campaign-images/' . \Illuminate\Support\Str::slug($title) . '.jpg';
        $fullPath = storage_path('app/public/' . $filename);
        
        $imageData = @file_get_contents($url);
        if ($imageData) {
            @mkdir(dirname($fullPath), 0755, true);
            file_put_contents($fullPath, $imageData);
            $c->featured_image = $filename;
            $c->save();
        }
    }
}

echo "Seeded maps and photos to Neon Postgres database!\n";
