<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class DealerUserInviteNotification extends Notification
{
    protected $validated;

    public function __construct($validated)
    {
        $this->validated = $validated;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function generateInvitationUrl(string $email)
    {
        return URL::temporarySignedRoute('employees.create', now()->addDay(), [
            'email' => $email,
            'name' => $this->validated['name'],
            'role' => $this->validated['role'],
            'store' => $this->validated['store'],
            'department' => $this->validated['department'],
        ]);
    }

    public function toMail($notifiable): MailMessage
    {
        $url = $this->generateInvitationUrl($notifiable->routes['mail']);

        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url($url))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
