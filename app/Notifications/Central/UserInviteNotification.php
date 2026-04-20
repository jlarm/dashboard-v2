<?php

declare(strict_types=1);

namespace App\Notifications\Central;

use App\Models\Central\UserInvite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class UserInviteNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly UserInvite $invite)
    {
        $this->afterCommit();
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $registrationUrl = URL::temporarySignedRoute(
            'employees.create',
            $this->invite->expires_at,
            ['centralUserInvite' => $this->invite->id],
        );

        return (new MailMessage)
            ->subject('Invitation to join '.config('app.name'))
            ->greeting('Hello '.$this->invite->name.',')
            ->line('You have been invited to join '.config('app.name').' as a Consultant.')
            ->line('Use the secure link below to complete your registration.')
            ->action('Complete Registration', $registrationUrl)
            ->line('This link expires on '.$this->invite->expires_at->toDayDateTimeString().'.');
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'central_user_invite_id' => $this->invite->id,
        ];
    }
}
