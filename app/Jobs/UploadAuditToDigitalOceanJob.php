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
        $pdf = Storage::get('/finance-audits/' . $this->financeAudit->pdf_path);
        $moved = Storage::disk('do-audits')->put(tenant('id') . '/finance/' . $this->financeAudit->pdf_path, $pdf);
        if($moved) {
            Storage::delete('/finance-audits/' . $this->financeAudit->pdf_path);
        }
    }
}
