<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Dealer\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InviteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private Invite $invite)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('no-reply@armp.app'),
            subject: 'Registration for '.tenant('name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.invite',
            with: [
                'name' => $this->invite->name,
                'company' => tenant('name'),
                'link' => 'https://'.tenant('domain').'/invite_registration/'.$this->invite->invitation_token,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
