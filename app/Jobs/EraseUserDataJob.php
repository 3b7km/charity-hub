<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class EraseUserDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    protected User $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Starting GDPR erasure for User ID: {$this->user->id}");

        // 1. Anonymise Donations (retain financial records, strip PII)
        Donation::where('donor_id', $this->user->id)->chunk(100, function ($donations) {
            foreach ($donations as $donation) {
                // Delete certificate file if it exists
                if ($donation->certificate_path && Storage::exists($donation->certificate_path)) {
                    Storage::delete($donation->certificate_path);
                }

                // Anonymise the donation record but keep the amount for the ledger
                $donation->update([
                    'donor_id' => null,
                    'certificate_path' => null,
                    // otherwise unlinking donor_id is sufficient for anonymisation
                ]);
            }
        });

        // 2. Anonymise User PII
        // We use a randomized hash so the email is no longer identifiable, 
        // but preserves DB constraints if necessary.
        $this->user->update([
            'name' => 'Anonymised User',
            'email' => 'erased_' . uniqid() . '@example.com',
        ]);

        // 3. Soft Delete the User
        $this->user->delete();

        Log::info("Completed GDPR erasure for User ID: {$this->user->id}");
    }
}
