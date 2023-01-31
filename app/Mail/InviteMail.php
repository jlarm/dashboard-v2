<?php

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

    public function __construct(Invite $invite)
    {
        $this->invite = $invite;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@' . tenant('domain')),
            subject: 'Registration for ' . tenant('name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.invite',
            with: [
                'name' => $this->invite->name,
                'role' => $this->invite->roles,
                'company' => tenant('name'),
                'link' => 'https://' . tenant('domain') . '/invite_registration/' . $this->invite->invitation_token,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
