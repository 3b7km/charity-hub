<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$campaign = \App\Models\Campaign::where('title', 'Clean Water Initiative')->first();
if ($campaign) {
    // A much better Unsplash photo for water:
    $url = 'https://images.unsplash.com/photo-1538300342682-ffa5ac837c6e?w=800&q=80';
    $filename = 'campaign-images/clean-water-initiative-new.jpg';
    $fullPath = storage_path('app/public/' . $filename);

    $imageData = @file_get_contents($url);
    if ($imageData) {
        file_put_contents($fullPath, $imageData);
        $campaign->featured_image = $filename;
        $campaign->save();
        echo "Updated Clean Water photo!\n";
    }
}
