<?php

namespace App\Notifications;

use App\Models\Dealer\VendorForm;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class VendorSignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public VendorForm $vendor;

    public function __construct(VendorForm $vendor)
    {
        $this->vendor = $vendor;
        ray($vendor->vendor->name . ' signed the vendor form.');
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => $this->vendor->vendor->name . ' signed the vendor form.'
        ];
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
