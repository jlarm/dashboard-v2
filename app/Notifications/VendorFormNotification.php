<?php

namespace App\Notifications;

use App\Models\Dealer\VendorForm;
use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class VendorFormNotification extends Notification
{
    public function __construct(public VendorForm $vendor)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function generateUrl(string $email)
    {
        return URL::temporarySignedRoute('dealer.vendor.form', now()->addYear(), [
            'vid' => $this->vendor->id,
            'email' => $email,
        ]);
    }

    public function toMail($notifiable): MailMessage
    {

        $url = $this->generateUrl($notifiable->routes['mail']);
        $user = User::role('Qualified Individual')->select('name', 'email')->first();

        return (new MailMessage)
            ->greeting('Hello '.$this->vendor->vendor->name.',')
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
