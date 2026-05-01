<?php

declare(strict_types=1);

namespace App\Jobs\Concerns;

use App\Models\Dealer\VendorEmailLog;
use App\Notifications\VendorFormNotification;
use Throwable;

trait HandlesVendorEmailDispatch
{
    private const RECENT_SEND_WINDOW_MINUTES = 10;

    public int $tries = 3;

    /**
     * @var array<int, int>
     */
    public array $backoff = [30, 120, 300];

    public function uniqueId(): string
    {
        return (string) $this->vendor->id;
    }

    public function uniqueFor(): int
    {
        return self::RECENT_SEND_WINDOW_MINUTES * 60;
    }

    private function alreadySentRecently(): bool
    {
        return VendorEmailLog::query()
            ->recentSuccessfulFor($this->vendor->id, self::RECENT_SEND_WINDOW_MINUTES)
            ->exists();
    }

    private function logFailedSend(?Throwable $exception): void
    {
        VendorEmailLog::query()->create([
            'vendor_form_id' => $this->vendor->id,
            'to' => $this->vendor->email ?? 'unknown',
            'subject' => VendorFormNotification::SUBJECT,
            'sent_at' => now()->toDateTimeString(),
            'status' => 'failed',
            'delivery_message' => $exception?->getMessage(),
        ]);
    }
}
