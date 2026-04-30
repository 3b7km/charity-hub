<?php

namespace App\Providers;

use App\Contracts\PaymentGatewayInterface;
use App\Events\DonationReceived;
use App\Listeners\GenerateCertificateListener;
use App\Listeners\RecordLedgerEntryListener;
use App\Listeners\SendThankYouEmailListener;
use App\Listeners\UpdateCampaignProgressListener;
use App\Services\Payment\PayMobGateway;
use App\Services\Payment\StripeGateway;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Payment gateway abstraction — swap by changing config('payment.default')
        $this->app->bind(PaymentGatewayInterface::class, function () {
            return match (config('payment.default', 'stripe')) {
                'stripe' => new StripeGateway(),
                'paymob' => new PayMobGateway(),
                default => throw new \InvalidArgumentException('Invalid payment gateway configured.'),
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register event listeners for the donation pipeline
        Event::listen(DonationReceived::class, UpdateCampaignProgressListener::class);
        Event::listen(DonationReceived::class, GenerateCertificateListener::class);
        Event::listen(DonationReceived::class, SendThankYouEmailListener::class);
        Event::listen(DonationReceived::class, RecordLedgerEntryListener::class);

        // Auto-assign donor role on registration
        Event::listen(\Illuminate\Auth\Events\Registered::class, \App\Listeners\AssignDonorRoleListener::class);

        // Rate limiter for donation endpoint
        RateLimiter::for('donate', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });
    }
}
