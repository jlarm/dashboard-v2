<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDealershipNotification extends Notification
{
    public function __construct(protected string $name)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Dealership Created')
            ->line($this->name.' has been added to the dashboard.');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
