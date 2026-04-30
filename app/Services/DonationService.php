<?php

namespace App\Services;

use App\Models\Donation;
use App\Models\Campaign;
use App\Models\CharitySubscription;
use App\Models\LedgerEntry;
use Illuminate\Support\Facades\DB;
use App\Events\DonationReceived;

class DonationService
{
    /**
     * Initiate a pending donation.
     */
    public function initiate(array $data)
    {
        return Donation::create([
            'amount' => $data['amount'],
            'campaign_id' => $data['campaign_id'],
            'donor_id' => auth()->id(),
            'idempotency_key' => $data['idempotency_key'],
            'gateway' => config('payment.default'),
            'status' => 'pending',
        ]);
    }

    /**
     * Confirm a donation (called by Webhook)
     */
    public function confirmDonation(string $donationId)
    {
        DB::transaction(function () use ($donationId) {
            $donation = Donation::findOrFail($donationId);
            
            if ($donation->status === 'confirmed') return;

            $donation->update(['status' => 'confirmed']);

            // Create Immutable Ledger Entry
            LedgerEntry::create([
                'donation_id' => $donation->id,
                'type' => 'credit',
                'amount' => $donation->amount,
            ]);

            // Update campaign raised amount synchronously
            $campaign = $donation->campaign;
            if ($campaign) {
                $campaign->increment('raised_amount', $donation->amount);
            }

            // Dispatch event for Certificates & Emails
            event(new DonationReceived($donation));
        });
    }

    public function markDonationFailed(string $donationId)
    {
        $donation = Donation::find($donationId);
        if ($donation) {
            $donation->update(['status' => 'failed']);
        }
    }

    public function processSubscriptionRenewal(string $stripeSubscriptionId, int $amountPaid)
    {
        $subscription = CharitySubscription::where('stripe_subscription_id', $stripeSubscriptionId)->first();
        if ($subscription) {
            $donation = Donation::create([
                'donor_id' => $subscription->donor_id,
                'campaign_id' => $subscription->campaign_id,
                'amount' => $amountPaid,
                'status' => 'pending',
                'gateway' => 'stripe',
                'idempotency_key' => uniqid('sub_ren_'),
            ]);
            $this->confirmDonation($donation->id);
        }
    }

    public function markSubscriptionPastDue(string $stripeSubscriptionId)
    {
        CharitySubscription::where('stripe_subscription_id', $stripeSubscriptionId)->update(['status' => 'past_due']);
    }

    public function cancelSubscription(string $stripeSubscriptionId)
    {
        CharitySubscription::where('stripe_subscription_id', $stripeSubscriptionId)->update(['status' => 'cancelled']);
    }

    public function refundDonation(string $paymentIntentId)
    {
        // For demonstration, we assume donation metadata has payment_intent_id
        // In reality, you would map it explicitly.
    }
}
