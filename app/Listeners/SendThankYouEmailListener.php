<?php

namespace App\Listeners;

use App\Events\DonationReceived;
use App\Jobs\SendCertificateEmailJob;

/**
 * Queued listener: dispatches thank-you email with certificate attachment.
 */
class SendThankYouEmailListener
{
    public function handle(DonationReceived $event): void
    {
        // Delay to allow certificate generation to complete first
        SendCertificateEmailJob::dispatch($event->donation)
            ->onQueue('emails')
            ->delay(now()->addSeconds(30));
    }
}
