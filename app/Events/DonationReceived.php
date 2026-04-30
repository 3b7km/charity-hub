<?php

namespace App\Events;

use App\Models\Donation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Dispatched when a donation is confirmed via webhook.
 *
 * Triggers:
 * - GenerateCertificateListener → GenerateCertificateJob (queue: default)
 * - SendThankYouEmailListener  → SendCertificateEmailJob (queue: emails)
 * - RecordLedgerEntryListener  → RecordLedgerEntryJob   (queue: default)
 * - UpdateCampaignProgressListener → (synchronous, fast)
 */
class DonationReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Donation $donation,
    ) {}
}
