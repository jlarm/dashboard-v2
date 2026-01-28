<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Dealer\VendorForm;
use App\Notifications\VendorFormNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class SendVendorEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected VendorForm $vendor) {}

    public function handle(): void
    {
        Notification::route('mail', $this->vendor->email)
            ->notify(new VendorFormNotification($this->vendor));
    }
}
