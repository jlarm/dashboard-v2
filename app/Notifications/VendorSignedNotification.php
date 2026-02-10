<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Dealer\VendorForm;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class VendorSignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public VendorForm $vendor)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => $this->vendor->vendor->name.' signed the vendor form.',
        ];
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
