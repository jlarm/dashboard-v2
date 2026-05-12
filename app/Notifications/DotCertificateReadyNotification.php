<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class DotCertificateReadyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @return list<string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Certificate ready',
            'message' => 'Your DOT Hazardous Materials Transportation certificate is now available in your profile.',
            'level' => 'success',
            'icon' => 'Award',
            'actions' => [
                [
                    'label' => 'View profile',
                    'url' => route('dealer.profile.edit'),
                    'variant' => 'default',
                ],
            ],
        ];
    }
}
