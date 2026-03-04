<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RemediationReminderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected bool $tenants,
        protected $user,
        protected $store,
        protected $auditType,
        protected $audit,
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('There '.($this->audit->outstanding_remediation_count === 1 ? 'is' : 'are')." {$this->audit->outstanding_remediation_count} outstanding {$this->auditType->label()} violation".($this->audit->outstanding_remediation_count === 1 ? '' : 's')." to remediate for {$this->store->name}.")
            ->action('Remediation Form', route('dealer.audit.osha.remediation', $this->audit->uuid));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
