<?php

namespace App\Jobs;

use App\Models\Donation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class GenerateCertificateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public array $backoff = [10, 60, 300];

    public function __construct(
        public readonly Donation $donation,
    ) {}

    public function handle(): void
    {
        $donation = $this->donation->load(['donor', 'campaign']);

        // Generate QR verification signed URL (permanent)
        $verifyUrl = URL::signedRoute('certificate.verify', [
            'donation' => $donation->id,
        ]);

        $data = [
            'donor_name' => $donation->donor?->name ?? 'Anonymous Donor',
            'amount' => $donation->formatted_amount,
            'campaign_name' => $donation->campaign->title,
            'donated_at' => $donation->donated_at?->format('F j, Y') ?? now()->format('F j, Y'),
            'certificate_id' => $donation->id,
            'verify_url' => $verifyUrl,
        ];

        $pdf = Pdf::loadView('pdf.certificate', $data);
        $pdf->setPaper('A4', 'landscape');

        $path = "certificates/{$donation->id}.pdf";
        Storage::disk('local')->put($path, $pdf->output());

        $donation->update(['certificate_path' => $path]);

        Log::info('Certificate generated', [
            'donation_id' => $donation->id,
            'path' => $path,
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::critical('Certificate generation failed permanently', [
            'donation_id' => $this->donation->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
