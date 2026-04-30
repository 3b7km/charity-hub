<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ExportDonorDataController extends Controller
{
    /**
     * Export all personal data for the authenticated donor.
     */
    public function export(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Gather all relevant data
        $data = [
            'profile' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'registered_at' => $user->created_at->toIso8601String(),
            ],
            'donations' => $user->donations()->with('campaign')->get()->map(function ($donation) {
                return [
                    'id' => $donation->id,
                    'amount' => $donation->formatted_amount,
                    'campaign' => $donation->campaign->title ?? null,
                    'status' => $donation->status,
                    'date' => $donation->created_at->toIso8601String(),
                ];
            }),
            'subscriptions' => $user->subscriptions()->get()->map(function ($sub) {
                return [
                    'id' => $sub->id,
                    'status' => $sub->status,
                    'started_at' => $sub->created_at->toIso8601String(),
                ];
            }),
            'volunteer_profile' => $user->volunteer ? [
                'skills' => $user->volunteer->skills,
                'total_hours' => $user->volunteer->total_hours,
                'shifts' => $user->volunteer->schedules()->get()->map(function ($shift) {
                    return [
                        'status' => $shift->status,
                        'hours_logged' => $shift->hours_logged,
                        'date' => $shift->shift_start->toIso8601String(),
                    ];
                }),
            ] : null,
        ];

        return response()->json($data, 200, [
            'Content-Disposition' => 'attachment; filename="charityhub-data-export.json"'
        ]);
    }
}
