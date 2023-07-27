<?php

namespace App\Jobs;

use App\Models\Dealer\Audit\FinanceAudit;
use File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Browsershot;

class GenerateAuditPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected FinanceAudit $financeAudit)
    {
    }

    private function rating(): float
    {
        $sum = 0;
        for ($i = 1; $i <= 43; $i++) {
            if ($this->financeAudit->{'finance_q' . $i .'_answer'} == 2) {
                $sum += 1;
            }
        }

        $wrong = $sum;
        return number_format(100 * (43 - $wrong) / 43, 2, '.', '');
    }

    public function handle(): void
    {
        $path = storage_path('app/finance-audits');
        if(tenant('locations')){
            $dealerName = str_replace(' ', '-', $this->financeAudit->store->name);
        } else {
            $dealerName = str_replace(' ', '-', tenant('name'));
        }
        $fileName = $this->financeAudit->audit_date->format('Ymd') . '-' . $dealerName . '-finance-audit.pdf';

        $html = view('dealer.audit.finance.download', [
            'financeAudit' => $this->financeAudit
        ])->render();

        if(!File::isDirectory($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        $audit = Browsershot::html($html)
            ->showBackground()
            ->margins(10, 10, 10, 10)
            ->scale(0.75)
            ->waitUntilNetworkIdle()
            ->save(storage_path('app/finance-audits/' . $fileName));

        $updatePath = $this->financeAudit->update([
            'pdf_path' => $fileName,
            'rating' => $this->rating(),
        ]);

    }
}
