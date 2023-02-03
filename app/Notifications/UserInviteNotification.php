<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class UserInviteNotification extends Notification
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
        ]);
    }

    public function toMail($notifiable): MailMessage
    {
        $url = $this->generateInvitationUrl($notifiable->routes['mail']);

        return (new MailMessage)
            ->subject($this->validated['name'].' ,Invitation to join '.tenant('name'))
            ->line('Click the button below to register .')
            ->action('Register', url($url))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
