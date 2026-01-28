<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContractSignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private Contract $contract) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Contract Signed by '.$this->contract->dealer_name.'.')
            ->line($this->contract->dealer_name.' has reviewed and signed the contract. The contract now needs to be signed by ARMP. Click the link below to view the contract.')
            ->action('View Contract', route('contracts.edit', $this->contract));
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
