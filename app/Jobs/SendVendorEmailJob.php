<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Jobs\Concerns\HandlesVendorEmailDispatch;
use App\Models\Dealer\VendorForm;
use App\Notifications\VendorFormNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Throwable;

class SendVendorEmailJob implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable, HandlesVendorEmailDispatch, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected VendorForm $vendor)
    {
        $this->afterCommit = true;
    }

    public function handle(): void
    {
        if ($this->alreadySentRecently()) {
            return;
        }

        Notification::route('mail', $this->vendor->email)
            ->notify(new VendorFormNotification($this->vendor));
    }

    public function failed(?Throwable $exception): void
    {
        if (! $exception instanceof Throwable) {
            return;
        }

        report($exception);

        $this->logFailedSend($exception);
    }
}
