<?php

namespace App\Listeners;

use App\Events\DonationReceived;
use App\Jobs\RecordLedgerEntryJob;

/**
 * Queued listener: dispatches ledger entry creation job.
 */
class RecordLedgerEntryListener
{
    public function handle(DonationReceived $event): void
    {
        RecordLedgerEntryJob::dispatch($event->donation)
            ->onQueue('default');
    }
}
