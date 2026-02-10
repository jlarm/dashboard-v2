<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Dealer\Audit\FinanceAudit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class UploadFinanceAuditImagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, WithMedia;

    public function __construct(public FinanceAudit $financeAudit)
    {
    }

    public function handle(): void
    {
        for ($i = 1; $i <= 49; $i++) {
            $this->financeAudit->syncFromMediaLibraryRequest($this->{'finance_q'.$i.'_images'})
                ->toMediaCollection('finance_q'.$i.'_images', 'digitalocean');
        }
    }
}
