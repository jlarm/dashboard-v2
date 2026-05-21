<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ComplianceSummaryMail extends Mailable
{
    public function __construct(
        public readonly string $storeName,
        public readonly string $reportPeriod,
        public readonly string $pdfPath,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address((string) config('mail.from.address'), (string) config('mail.from.name')),
            subject: "{$this->storeName} Compliance Summary — {$this->reportPeriod}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.compliance-summary',
            with: [
                'storeName' => $this->storeName,
                'reportPeriod' => $this->reportPeriod,
            ],
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $fileName = 'compliance-summary-'.str_replace(' ', '-', mb_strtolower($this->reportPeriod)).'.pdf';

        return [
            Attachment::fromPath($this->pdfPath)
                ->as($fileName)
                ->withMime('application/pdf'),
        ];
    }
}
