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
use Illuminate\Support\Facades\Notification;
use Throwable;

class IncompleteVendorNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected VendorForm $vendor) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (! filter_var($this->vendor->email, FILTER_VALIDATE_EMAIL)) {
            return;
        }

        Notification::route('mail', $this->vendor->email)
            ->notify(new VendorFormNotification($this->vendor));
    }

    public function failed(?Throwable $exception): void
    {
        report_if($exception instanceof Throwable, $exception);
    }
}
