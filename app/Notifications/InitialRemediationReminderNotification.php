<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InitialRemediationReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected bool $tenants,
        protected \App\Models\User $user,
        protected \App\Models\Dealer\Store $store,
        protected \App\Enums\AuditTypes $auditType,
        protected \App\Models\Dealer\Audit\Contracts\ViolationAudit&\Illuminate\Database\Eloquent\Model $audit
    ) {}

    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->auditType->label().' audit has been completed')
            ->greeting('Hello '.$this->user->name.',')
            ->line('An '.$this->auditType->label().' audit has been completed for '.$this->store->name.'.')
            ->line('Please remediate any violations as soon as possible.')
            ->action('Remediation Form', route('dealer.audit.osha.remediation', $this->audit->uuid))
            ->line('');
    }

    public function toArray(mixed $notifiable): array
    {
        return [];
    }
}
