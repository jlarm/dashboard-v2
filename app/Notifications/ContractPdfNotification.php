<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class ContractPdfNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Contract $contract) {}

    /**
     * @return array<int, string>
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->contract->dealer_name.' ARMP Contract PDF')
            ->line('Thank you for your patronage please see finalized contract should you have any questions or concerns please let us know.')
            ->line($this->contract->user->name.' - '.$this->contract->user->email)
            ->attach(Storage::disk('armpcon')->temporaryUrl($this->contract->pdf_path, now()->addMinutes(2)), [
                'as' => str_replace(' ', '-', mb_strtolower($this->contract->dealer_name)).'-armp-contract.pdf',
                'mime' => 'application/pdf',
            ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(mixed $notifiable): array
    {
        return [];
    }
}
