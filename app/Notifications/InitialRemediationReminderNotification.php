<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InitialRemediationReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected $user,
        protected $store,
        protected $auditType,
        protected $audit
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->auditType->label() . ' audit has been completed')
            ->greeting('Hello ' . $this->user->name . ',')
            ->line('An ' . $this->auditType->label() . ' audit has been completed for ' . $this->store->name . '.') 
            ->line('Please remediate any violations as soon as possible.')
            ->action('Remediation Form', route('dealer.audit.osha.remediation', $this->audit->uuid))
            ->line('');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
