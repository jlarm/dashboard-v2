<?php

declare(strict_types=1);

namespace App\Mail\Tenant;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SdsRequestMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public string $chemicalName,
        public ?string $manufacturer,
        public string $requesterName,
        public string $requesterEmail,
        public string $tenantName,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New SDS Sheet Request - '.$this->tenantName,
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.tenant.sds-request');
    }
}
