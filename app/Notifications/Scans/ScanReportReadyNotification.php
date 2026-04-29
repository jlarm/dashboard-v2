<?php

declare(strict_types=1);

namespace App\Notifications\Scans;

use Illuminate\Notifications\Notification;

class ScanReportReadyNotification extends Notification
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
            'title' => $label.' Report Ready',
            'message' => 'Your '.$label.' scan report for '.$this->storeName.' has been generated and is ready to download.',
            'level' => 'success',
            'icon' => 'CheckCircle2',
            'actions' => [
                [
                    'label' => 'Download Report',
                    'url' => route('dealer.scan.report', ['type' => $this->type]),
                    'variant' => 'default',
                ],
            ],
        ];
    }
}
