<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Dealer\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TenDayOpenInviteReminderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(private Invite $invite) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address((string) config('mail.from.address'), (string) config('mail.from.name')),
            subject: 'Registration Reminder for '.tenant('name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.ten-day-open-invite-reminder',
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
