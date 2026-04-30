<?php

namespace App\Http\Controllers;

use App\Http\Requests\DonationRequest;
use App\Models\Campaign;
use App\Models\Donation;
use App\Services\DonationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function __construct(
        private DonationService $donationService,
    ) {}

    /**
     * POST /api/donations
     * Initiate a one-time donation. Returns client_secret for Stripe.js confirmation.
     */
    public function store(DonationRequest $request): JsonResponse
    {
        $campaign = Campaign::findOrFail($request->campaign_id);
        $donor = Auth::user();

        if (!$campaign->isActive()) {
            return response()->json([
                'message' => 'This campaign is no longer accepting donations.',
            ], 422);
        }

        $result = $this->donationService->initiate(
            campaign: $campaign,
            donor: $donor,
            amountCents: $request->amount,
            currency: $request->input('currency', 'GBP'),
            idempotencyKey: $request->idempotency_key,
        );

        if (!$result->success) {
            return response()->json([
                'message' => 'Payment initiation failed.',
                'error' => $result->errorMessage,
            ], 422);
        }

        return response()->json([
            'client_secret' => $result->clientSecret,
            'gateway_ref' => $result->gatewayRef,
        ]);
    }

    /**
     * GET /api/donations/{id}
     * Get donation status for the authenticated donor.
     */
    public function show(Donation $donation): JsonResponse
    {
        $this->authorize('view', $donation);

        return response()->json([
            'id' => $donation->id,
            'amount' => $donation->formatted_amount,
            'status' => $donation->status,
            'campaign' => $donation->campaign->title,
            'donated_at' => $donation->donated_at?->toIso8601String(),
            'certificate_url' => $donation->certificate_path
                ? route('certificate.download', $donation)
                : null,
        ]);
    }

    /**
     * Export all confirmed donations for the authenticated donor as PDF.
     */
    public function exportPdf()
    {
        $user = Auth::user();
        $donations = $user->donations()
            ->with('campaign')
            ->where('status', 'confirmed')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($donations->isEmpty()) {
            return back()->with('error', 'No confirmed donations found to export.');
        }

        $totalAmount = $donations->sum('amount');
        
        $data = [
            'user' => $user,
            'donations' => $donations,
            'totalAmount' => $totalAmount,
            'generatedAt' => now()->format('F j, Y'),
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.donation-history', $data);

        return $pdf->download("CharityHub_Donation_History_{$user->id}.pdf");
    }
}
