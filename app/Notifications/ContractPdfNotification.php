<?php

namespace App\Notifications;

use App\Models\Contract;
use File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Spatie\Browsershot\Browsershot;

class ContractPdfNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Contract $contract)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    private function createFileName(): string
    {
        return strtolower(str_replace(' ', '-', $this->contract->dealer_name)) . '-' . 'armp-contract' . '-' . $this->contract->created_at->format('Y-m-d') . '.pdf';
    }

    public function toMail($notifiable): MailMessage
    {
        $pdfContent = $this->contract->pdf();

        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->line('Thank you for using our application!')
            ->attachData($pdfContent, $this->createFileName(), [
                'mime' => 'application/pdf',
            ]);
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
