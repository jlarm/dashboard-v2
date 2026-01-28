<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class ContractNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $name;
    protected $email;

    public function __construct(protected Contract $contract)
    {
        $this->name = $this->contract->user->name;
        $this->email = $this->contract->user->email;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = $this->generateUrl();

        return (new MailMessage)
            ->subject('ARMP Contract for '.$this->contract->dealer_name)
            ->greeting('Hello,')
            ->line('Here is your contract for the services agreed to. All you need to do is review it, sign it and submit it.')
            ->action('Review Contract', url($url))
            ->line('This link will expire in 7 days.')
            ->line('If you have any questions please feel free to contact us at any time.')
            ->line('Your contact: '.$this->name.' - '.$this->email);
    }

    public function toArray($notifiable): array
    {
        return [];
    }

    protected function generateUrl()
    {
        return URL::temporarySignedRoute('contracts.show', now()->addDays(7), [
            'contract' => $this->contract->uuid,
        ]);
    }
}
