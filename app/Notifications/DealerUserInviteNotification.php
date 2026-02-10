<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class DealerUserInviteNotification extends Notification
{
    public function __construct(protected $validated) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function generateUrl(string $email)
    {
        return URL::temporarySignedRoute('dealer.vendor.create', now()->addDay(), [
            'id' => $this->validated->id,
        ]);
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
            ->line('You have been invited to join the '.$this->validated->store.' compliance dashboard. Please click the link below to finish your registration.')
            ->action('Notification Action', url($url))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
