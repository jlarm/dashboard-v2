<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IncompleteCoursesNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly string $userName,
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Reminder: You have incomplete courses')
            ->greeting('Hello '.$this->userName.',')
            ->line('You have courses that have not been started.')
            ->action('View Courses', url('/courses'))
            ->salutation('Please complete these courses at your earliest convenience.');
    }
}
