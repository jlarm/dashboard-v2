<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Dealer\VendorForm;
use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Symfony\Component\Mime\Email;

class VendorFormNotification extends Notification
{
    public const string SUBJECT = 'Vendor Form Notification';

    public function __construct(public VendorForm $vendor) {}

    /**
     * @return array<int, string>
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    public function generateUrl(string $email): string
    {
        return URL::temporarySignedRoute('dealer.vendor.form', now()->addYear(), [
            'vid' => $this->vendor->id,
            'email' => $email,
        ]);
    }

    public function toMail(mixed $notifiable): MailMessage
    {

        $url = $this->generateUrl($notifiable->routes['mail']);
        $user = User::query()->role('Qualified Individual')->select('name', 'email')->first();

        return (new MailMessage)
            ->greeting('Hello '.$this->vendor->vendor?->name.',')
            ->line('Please click the button below to fill out our 3rd party service provider form for '.tenant('name').'.')
            ->action('Click Here', url($url))
            ->line('If you have any questions, please contact '.$user?->name.' at '.$user?->email)
            ->line('Thank you for your time!')
            ->salutation(tenant('name'))
            ->withSymfonyMessage(function (Email $message): void {
                $message->getHeaders()->addTextHeader('X-Vendor-Notification', 'true');
                $message->getHeaders()->addTextHeader('X-Vendor-ID', (string) $this->vendor->id);

                // Ensure Message-ID is set before sending
                if (! $message->getHeaders()->has('Message-ID')) {
                    $domain = config('mail.from.address') ? explode('@', (string) config('mail.from.address'))[1] : 'localhost';
                    $messageId = sprintf('%s.%s@%s', uniqid('vendor', true), time(), $domain);
                    $message->getHeaders()->addIdHeader('Message-ID', $messageId);
                }
            });
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(mixed $notifiable): array
    {
        return [];
    }
}
