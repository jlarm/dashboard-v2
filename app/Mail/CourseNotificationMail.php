<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class CourseNotificationMail extends Mailable
{
    public function __construct(
        public string $courseLink
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@armp.app'),
            subject: 'Required Harassment Course Notification',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.course-notification',
            with: [
                'courseLink' => $this->courseLink,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
