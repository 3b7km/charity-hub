<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ── Redirect /admin/login to unified /login ──────────────────────────
Route::get('/admin/login', function () {
    return redirect('/login');
});

// Static pages
Route::get('/impact', [\App\Http\Controllers\UIController::class, 'impact'])->name('impact');
Route::get('/about', [\App\Http\Controllers\UIController::class, 'about'])->name('about');
Route::get('/transparency', [\App\Http\Controllers\UIController::class, 'transparency'])->name('transparency');
Route::get('/ledger/download', [\App\Http\Controllers\LedgerController::class, 'downloadCsv'])->name('ledger.download');

// Authentication (unified login for all roles)
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('/register', [\App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);

// Dashboard, Profiles & Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/donations/export', [\App\Http\Controllers\DonationController::class, 'exportPdf'])->name('donor.donations.export');
    Route::get('/certificate/download/{donation}', [\App\Http\Controllers\CertificateController::class, 'download'])->name('donor.certificate.download');
    Route::get('/volunteer/dashboard', [\App\Http\Controllers\VolunteerController::class, 'dashboard'])->name('volunteer.dashboard');

    Route::post('/logout', function () {
        \Illuminate\Support\Facades\Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});

// Public campaign pages
Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
Route::get('/campaigns/{campaign:slug}', [CampaignController::class, 'show'])->name('campaigns.show');
Route::get('/campaigns/{campaign:slug}/impact', [CampaignController::class, 'impact'])->name('campaigns.impact');

// Public certificate verification
Route::get('/verify/certificate/{donation}', [\App\Http\Controllers\CertificateController::class, 'verify'])->name('certificate.verify');

// Stripe webhooks (no CSRF, no auth)
Route::post('/webhooks/stripe', [WebhookController::class, 'handleStripe'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->name('webhooks.stripe');
