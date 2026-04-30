<?php

namespace App\Http\Controllers;

use App\Services\Reporting\LedgerService;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    public function __construct(
        protected LedgerService $ledgerService
    ) {}

    /**
     * Download the full transparency ledger as CSV.
     */
    public function downloadCsv()
    {
        return $this->ledgerService->exportToCsv();
    }
}
