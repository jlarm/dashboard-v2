<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class UserInviteNotification extends Notification
{
    public function __construct(protected $validated) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = $this->generateInvitationUrl($notifiable->routes['mail']);

        return (new MailMessage)
            ->subject($this->validated['name'].' ,Invitation to join '.tenant('name'))
            ->line('Click the button below to register.')
            ->action('Register', url($url));
    }

    public function toArray($notifiable): array
    {
        return [];
    }

    protected function generateInvitationUrl(string $email)
    {
        return URL::temporarySignedRoute('employees.create', now()->addDay(), [
            'email' => $email,
            'name' => $this->validated['name'],
            'role' => 'Consultant',
        ]);
    }
}
