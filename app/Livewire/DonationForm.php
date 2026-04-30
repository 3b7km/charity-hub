<?php

namespace App\Livewire;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\LedgerEntry;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DonationForm extends Component
{
    public $campaignId;
    public $amount = 25;
    public $fullName;
    public $email;
    public $isAnonymous = false;
    public $paymentMethod = 'stripe';
    public $showSuccess = false;
    public $lastDonationId;

    protected $rules = [
        'amount' => 'required|numeric|min:1',
        'fullName' => 'required|string|min:3',
        'email' => 'required|email',
    ];

    public function mount($campaignId)
    {
        $this->campaignId = $campaignId;
        if (auth()->check()) {
            $this->fullName = auth()->user()->name;
            $this->email = auth()->user()->email;
        }
    }

    public function setAmount($value)
    {
        $this->amount = $value;
    }

    public function processDonation()
    {
        // 9. Donors must be logged in to make a donation
        if (!auth()->check()) {
            session()->flash('error', 'Please login to make a donation.');
            return;
        }

        $this->validate();

        $campaign = Campaign::findOrFail($this->campaignId);
        
        // 11. A donation is successful only if the campaign is still active and its deadline has not passed.
        if ($campaign->status !== 'active') {
            session()->flash('error', 'Campaign No Longer Accepting Donations');
            return;
        }

        if ($campaign->end_date && $campaign->end_date->isPast()) {
            session()->flash('error', 'Campaign No Longer Accepting Donations (Expired)');
            return;
        }

        $amountCents = (int)($this->amount * 100);

        try {
            DB::transaction(function () use ($campaign, $amountCents) {
                // 1. Create donation record
                $donation = Donation::create([
                    'campaign_id' => $campaign->id,
                    'donor_id' => auth()->id() ?? '00000000-0000-0000-0000-000000000000', // System user or handle anonymous
                    'amount' => $amountCents,
                    'currency' => 'GBP',
                    'status' => 'confirmed', // Mark as confirmed for demo
                    'gateway' => 'stripe',
                    'gateway_ref' => 'SIM_' . Str::random(10),
                    'type' => 'one_time',
                    'donated_at' => now(),
                ]);

                // 2. Update campaign raised amount
                $campaign->increment('raised_amount', $amountCents);

                // 3. Create ledger entry for transparency
                LedgerEntry::create([
                    'donation_id' => $donation->id,
                    'type' => 'credit', // Matches enum: credit, debit, refund
                    'amount' => $amountCents,
                    'balance_after' => $campaign->raised_amount,
                    'notes' => ($this->isAnonymous ? 'Anonymous' : $this->fullName) . ' supported this project.',
                ]);

                $this->lastDonationId = $donation->id;
            });

            $this->showSuccess = true;
            $this->dispatch('donation-completed');
            
        } catch (\Exception $e) {
            // Log the error for debugging
            \Illuminate\Support\Facades\Log::error('Donation Error: ' . $e->getMessage());
            session()->flash('error', 'Processing Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.donation-form');
    }
}
