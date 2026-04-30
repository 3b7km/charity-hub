<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificateController extends Controller
{
    /**
     * Download a donation certificate.
     */
    public function download(Donation $donation)
    {
        // Ensure only the owner (or admin) can download
        if ($donation->donor_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }

        if ($donation->status !== 'confirmed') {
            return back()->with('error', 'Certificate only available for confirmed donations.');
        }

        $verifyUrl = route('certificate.verify', ['donation' => $donation->id]);
        
        // Generate QR code for the certificate as SVG (no Imagick required)
        $qrCode = QrCode::format('svg')
            ->size(200)
            ->margin(1)
            ->color(0, 82, 53) // Emerald Primary
            ->generate($verifyUrl);

        $data = [
            'donation' => $donation->load(['campaign', 'donor']),
            'qrCode' => $qrCode,
        ];

        $pdf = Pdf::loadView('pdf.certificate', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->download("CharityHub_Certificate_{$donation->id}.pdf");
    }

    /**
     * Public verification route for the QR code.
     */
    public function verify(Donation $donation)
    {
        return view('pages.verify-certificate', compact('donation'));
    }
}
