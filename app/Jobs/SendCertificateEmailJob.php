<?php

namespace App\Jobs;

use App\Mail\DonorCertificateMail;
use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendCertificateEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public array $backoff = [30, 120, 600];

    public function __construct(
        public readonly Donation $donation,
    ) {
        $this->onQueue('emails');
    }

    public function handle(): void
    {
        $donation = $this->donation->load(['donor', 'campaign']);

        if (!$donation->donor) {
            Log::warning('Cannot send certificate email — no donor record', [
                'donation_id' => $donation->id,
            ]);
            return;
        }

        Mail::to($donation->donor->email)
            ->send(new DonorCertificateMail($donation));

        Log::info('Certificate email sent', [
            'donation_id' => $donation->id,
            'donor_email' => $donation->donor->email,
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::critical('Certificate email failed permanently', [
            'donation_id' => $this->donation->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
