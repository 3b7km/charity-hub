<?php

namespace App\Listeners;

use App\Events\DonationReceived;
use App\Jobs\GenerateCertificateJob;

/**
 * Queued listener: dispatches certificate PDF generation job.
 */
class GenerateCertificateListener
{
    public function handle(DonationReceived $event): void
    {
        GenerateCertificateJob::dispatch($event->donation)
            ->onQueue('default');
    }
}
