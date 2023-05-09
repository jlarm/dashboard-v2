<?php

namespace App\Jobs;

use App\Models\Dealer\Audit\FinanceAudit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class UploadAuditToDigitalOceanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected FinanceAudit $financeAudit)
    {
    }

    public function middleware(): array
    {
        return [new WithoutOverlapping($this->financeAudit)];
    }

    public function handle(): void
    {
        $path = storage_path('app/finance-audits');
        $dealerName = str_replace(' ', '-', tenant('name'));
        $fileName = $this->financeAudit->audit_date->format('Ymd') . '-' . $dealerName . '-finance-audit.pdf';
        $pdf = Storage::get('/finance-audits/' . $fileName);

        Storage::disk('do-audits')->put(tenant('id') . '/audits/finance/' . $fileName, $pdf);

        $updatePath = $this->financeAudit->update([
            'pdf_path' => $fileName,
        ]);

    }
}
