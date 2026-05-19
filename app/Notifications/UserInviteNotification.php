<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class UserInviteNotification extends Notification
{
    /**
     * @param  array<string, mixed>  $validated
     */
    public function __construct(protected array $validated) {}

    /**
     * @return array<int, string>
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        $url = $this->generateInvitationUrl($notifiable->routes['mail']);

        return (new MailMessage)
            ->subject($this->validated['name'].' ,Invitation to join '.tenant('name'))
            ->line('Click the button below to register.')
            ->action('Register', url($url));
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(mixed $notifiable): array
    {
        return [];
    }

    protected function generateInvitationUrl(string $email): string
    {
        return URL::temporarySignedRoute('employees.create', now()->addDay(), [
            'email' => $email,
            'name' => $this->validated['name'],
            'role' => 'Consultant',
        ]);
    }
}
