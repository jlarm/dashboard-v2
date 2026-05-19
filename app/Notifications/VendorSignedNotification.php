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

    public function __construct(public VendorForm $vendor) {}

    public function via(mixed $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(mixed $notifiable): array
    {
        return [
            'message' => $this->vendor->vendor->name.' signed the vendor form.',
        ];
    }

    public function toArray(mixed $notifiable): array
    {
        return [];
    }
}
