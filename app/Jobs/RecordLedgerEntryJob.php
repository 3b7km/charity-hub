<?php

namespace App\Jobs;

use App\Models\Donation;
use App\Models\LedgerEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RecordLedgerEntryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public array $backoff = [5, 30, 120];

    public function __construct(
        public readonly Donation $donation,
    ) {}

    public function handle(): void
    {
        $donation = $this->donation->load('campaign');

        DB::transaction(function () use ($donation) {
            // Calculate running balance: current raised amount on campaign
            $balanceAfter = $donation->campaign->raised_amount;

            // Create append-only credit entry
            $entry = new LedgerEntry();
            $entry->forceFill([
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'donation_id' => $donation->id,
                'type' => 'credit',
                'amount' => $donation->amount,
                'balance_after' => $balanceAfter,
                'notes' => "Donation confirmed for campaign: {$donation->campaign->title}",
            ]);
            $entry->save();

            Log::info('Ledger entry recorded', [
                'donation_id' => $donation->id,
                'type' => 'credit',
                'amount' => $donation->amount,
                'balance_after' => $balanceAfter,
            ]);
        });
    }

    public function failed(\Throwable $exception): void
    {
        Log::critical('Ledger entry recording failed', [
            'donation_id' => $this->donation->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
