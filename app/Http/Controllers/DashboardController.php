<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $donations = Donation::where('donor_id', $user->id)
            ->with('campaign')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $totalDonated = $donations->where('status', 'confirmed')->sum('amount');
        $campaignsCount = $donations->pluck('campaign_id')->unique()->count();
        
        return view('dashboard.index', compact('donations', 'totalDonated', 'campaignsCount'));
    }
}

