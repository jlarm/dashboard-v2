<?php

declare(strict_types=1);

namespace App\Notifications\Scans;

use Illuminate\Notifications\Notification;

class ScanReportFailedNotification extends Notification
{
    public function __construct(
        public readonly string $type,
        public readonly string $storeName,
    ) {}

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
        $label = ucfirst($this->type);

        return [
            'title' => 'Report Generation Failed',
            'message' => 'We were unable to generate the '.$label.' report for '.$this->storeName.'. Please try again.',
            'level' => 'error',
            'icon' => 'AlertTriangle',
            'actions' => [],
        ];
    }
}
