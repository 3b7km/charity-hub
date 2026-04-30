<?php

namespace App\Mail;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DonorCertificateMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Donation $donation,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Thank You for Your Donation to {$this->donation->campaign->title}!",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.donation-confirmed',
            with: [
                'donorName' => $this->donation->donor?->name ?? 'Anonymous Donor',
                'amount' => $this->donation->formatted_amount,
                'campaignTitle' => $this->donation->campaign->title,
                'donatedAt' => $this->donation->donated_at?->format('F j, Y'),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        if ($this->donation->certificate_path && Storage::disk('local')->exists($this->donation->certificate_path)) {
            $attachments[] = Attachment::fromStorage($this->donation->certificate_path)
                ->as('DonationCertificate.pdf')
                ->withMime('application/pdf');
        }

        return $attachments;
    }
}
