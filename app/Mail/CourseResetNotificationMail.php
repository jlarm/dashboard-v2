<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CourseResetNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $userName,
        public string $tenantName,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: 'noreply@armp.app',
            subject: 'Your Training Courses Have Been Reset'
        );
    }

    public function content(): Content
    {
        return new Content(
            text: 'emails.course-reset-notification',
            with: [
                'userName' => $this->userName,
                'tenantName' => $this->tenantName,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
