<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class UserInviteNotification extends Notification
{
    public function __construct(User $user)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function generateInvitationUrl(string $email)
    {
        return URL::temporarySignedRoute('employees.create', now()->addDay(), [
            'email' => $email
        ]);
    }

    public function toMail($notifiable): MailMessage
    {
        $url = $this->generateInvitationUrl($notifiable->routes['mail']);
        return (new MailMessage)
            ->subject('Invitation to join Automotive Risk Management Partners')
            ->line('Click the button below to register.')
            ->action('Register', url($url))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
