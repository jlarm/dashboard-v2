<?php

namespace App\Notifications;

use App\Models\User;
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
        $user = User::role('Qualified Individual')->select('name', 'email')->first();

        ray($user);

        return (new MailMessage)
            ->greeting('Hello '.$this->vendor->contact_name.',')
            ->line('Please click the button below to fill out our 3rd party service provider form for '.tenant('name').'.')
            ->action('Click Here', url($url))
            ->line('If you have any questions, please contact '.$user->name.' at '.$user->email)
            ->salutation('Thank you for your time!'.'<br>'.tenant('name'));
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
