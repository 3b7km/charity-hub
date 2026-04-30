<?php

namespace App\Listeners;

use App\Events\DonationReceived;
use App\Models\Campaign;
use Illuminate\Support\Facades\DB;

/**
 * Synchronously update campaign raised_amount on each confirmed donation.
 * Runs inline (not queued) for immediate progress bar accuracy.
 */
class UpdateCampaignProgressListener
{
    public function handle(DonationReceived $event): void
    {
        DB::transaction(function () use ($event) {
            Campaign::where('id', $event->donation->campaign_id)
                ->increment('raised_amount', $event->donation->amount);
        });
    }
}
