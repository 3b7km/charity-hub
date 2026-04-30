<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\View\View;

class CampaignController extends Controller
{
    /**
     * GET /campaigns
     * Public listing of active campaigns.
     */
    public function index(): View
    {
        $campaigns = Campaign::active()
            ->with('media')
            ->withCount('confirmedDonations')
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('campaigns.index', compact('campaigns'));
    }

    /**
     * GET /campaigns/{slug}
     * Public campaign detail page with Livewire components.
     */
    public function show(Campaign $campaign): View
    {
        $campaign->load(['confirmedDonations.donor', 'beneficiaryLocations', 'impactReports' => function ($q) {
            $q->published();
        }]);

        $locations = $campaign->beneficiaryLocations;

        // SEO meta tags
        $meta = [
            'title' => $campaign->title . ' — CharityHub',
            'description' => \Illuminate\Support\Str::limit(strip_tags($campaign->description), 160),
            'image' => $campaign->featured_image_url,
            'url' => url("/campaigns/{$campaign->slug}"),
        ];

        return view('campaigns.show', compact('campaign', 'meta', 'locations'));
    }

    /**
     * GET /campaigns/{slug}/impact
     * Public campaign impact page.
     */
    public function impact(Campaign $campaign): View
    {
        $locations = $campaign->beneficiaryLocations;

        return view('campaigns.impact', compact('campaign', 'locations'));
    }
}
