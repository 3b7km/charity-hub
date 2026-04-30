<?php

use App\Http\Controllers\DonationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->group(function () {

    // Donor Export
    Route::get('/donors/export', [\App\Http\Controllers\ExportDonorDataController::class, 'export'])
        ->name('api.donors.export');

    // Donations
    Route::post('/donations', [DonationController::class, 'store'])
        ->middleware('throttle:donate')
        ->name('api.donations.store');

    Route::get('/donations/{donation}', [DonationController::class, 'show'])
        ->name('api.donations.show');

    // Campaigns (public listing doesn't need auth, but creation does)
    Route::get('/campaigns', [\App\Http\Controllers\CampaignController::class, 'index'])
        ->withoutMiddleware(['auth:sanctum'])
        ->name('api.campaigns.index');

    // Volunteer endpoints
    Route::prefix('volunteers')->group(function () {
        Route::post('/register', function (\Illuminate\Http\Request $request) {
            $validated = $request->validate([
                'skills' => 'nullable|array',
                'availability' => 'nullable|array',
                'emergency_contact' => 'nullable|string',
            ]);

            $volunteer = \App\Models\Volunteer::create([
                'user_id' => auth()->id(),
                ...$validated,
            ]);

            return response()->json($volunteer, 201);
        })->name('api.volunteers.register');

        Route::get('/schedules', function () {
            $volunteer = \App\Models\Volunteer::where('user_id', auth()->id())->firstOrFail();
            return response()->json(
                $volunteer->upcomingSchedules()->with('campaign')->get()
            );
        })->name('api.volunteers.schedules');
    });
});
