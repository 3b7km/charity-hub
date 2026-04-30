<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Campaign;

class CampaignProgressBar extends Component
{
    public $campaignId;

    public function render()
    {
        $campaign = Campaign::findOrFail($this->campaignId);
        
        return view('livewire.campaign-progress-bar', [
            'percentage' => $campaign->progress_percentage,
            'raised' => $campaign->formatted_raised,
            'goal' => $campaign->formatted_goal,
        ]);
    }
}
