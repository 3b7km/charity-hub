<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Donation;

class DonationFeed extends Component
{
    public $campaignId;

    public function render()
    {
        $query = Donation::where('status', 'confirmed')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->with(['donor', 'campaign']);

        if ($this->campaignId) {
            $query->where('campaign_id', $this->campaignId);
        }

        return view('livewire.donation-feed', [
            'donations' => $query->get(),
        ]);
    }

}
