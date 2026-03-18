<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Sends a password reset email to a tenant user with a pre-built reset URL.
 * Not queued — dispatched synchronously from within CrossTenantPasswordResetJob
 * to avoid model deserialization outside the tenant context.
 */
class TenantResetPasswordNotification extends Notification
{
    public function __construct(protected string $resetUrl) {}

    /**
     * @return array<int, string>
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        $expiresInMinutes = config('auth.passwords.users.expire');

        return (new MailMessage)
            ->subject('Reset Password Notification')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', $this->resetUrl)
            ->line("This password reset link will expire in {$expiresInMinutes} minutes.")
            ->line('If you did not request a password reset, no further action is required.');
    }
}
