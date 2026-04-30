<?php

namespace App\Services\Reporting;

use App\Models\LedgerEntry;
use Illuminate\Support\Facades\Response;

class LedgerService
{
    /**
     * Export the full transparency ledger to CSV.
     */
    public function exportToCsv()
    {
        $entries = LedgerEntry::with('donation.campaign', 'donation.donor')
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = "charityhub_ledger_" . now()->format('Y-m-d') . ".csv";
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Date', 'Type', 'Amount', 'Balance After', 'Campaign', 'Donor', 'Notes'];

        $callback = function() use($entries, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($entries as $entry) {
                fputcsv($file, [
                    $entry->id,
                    $entry->created_at->format('Y-m-d H:i:s'),
                    strtoupper($entry->type),
                    $entry->formatted_amount,
                    '£' . number_format($entry->balance_after / 100, 2),
                    $entry->donation?->campaign?->title ?? 'N/A',
                    $entry->donation?->donor?->name ?? 'Anonymous',
                    $entry->notes
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
