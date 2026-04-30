<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\LedgerEntry;
use Illuminate\Http\Request;

class UIController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function impact()
    {
        $stats = [
            'total_raised' => Donation::confirmed()->sum('amount'),
            'campaign_count' => Campaign::active()->count(),
            'donor_count' => Donation::confirmed()->distinct('donor_id')->count('donor_id'),
            'beneficiary_count' => \App\Models\ImpactReport::sum('beneficiary_count') ?: 1200000, // Fallback if no reports yet
        ];

        return view('pages.impact', compact('stats'));
    }

    public function transparency()
    {
        $ledgerEntries = LedgerEntry::with(['donation.campaign', 'donation.donor'])
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        return view('pages.transparency', compact('ledgerEntries'));
    }
}

