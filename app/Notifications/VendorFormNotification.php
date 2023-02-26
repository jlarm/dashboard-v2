<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class VendorFormNotification extends Notification
{
    public $vendor;

    public function __construct($vendor)
    {
        $this->vendor = $vendor;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function generateUrl(string $email)
    {
        return URL::temporarySignedRoute('dealer.vendor.create', now()->addDay(), [
            'email' => $email,
            'name' => $this->vendor['contact_name'],
        ]);
    }

    public function toMail($notifiable): MailMessage
    {
        $url = $this->generateUrl($notifiable->routes['mail']);

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
