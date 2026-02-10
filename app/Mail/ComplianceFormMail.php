<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComplianceFormMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public $signedUrl, public $storeName) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: 'noreply@armp.app',
            subject: $this->storeName.' Compliance Form',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.compliance-form',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
