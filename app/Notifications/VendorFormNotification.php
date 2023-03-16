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
            'id' => $this->vendor->id,
        ]);
    }

    public function toMail($notifiable): MailMessage
    {
        $url = $this->generateUrl($notifiable->routes['mail']);

        return (new MailMessage)
            ->line('Please click the button below to fill out our 3rd party service provider form.')
            ->action('Click Here', url($url))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
