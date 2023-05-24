<?php

namespace App\Jobs;

use App\Models\Dealer\Audit\IndividualAudit;
use File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Browsershot;

class GenerateIndividualAuditPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected IndividualAudit $individualAudit)
    {
    }

    public function handle(): void
    {
        $path = storage_path('app/individual-audits');
        if(tenant('locations')){
            $dealerName = str_replace(' ', '-', $this->individualAudit->store->name);
        } else {
            $dealerName = str_replace(' ', '-', tenant('name'));
        }
        $fileName = $this->individualAudit->audit_date->format('Ymd') . '-' . $dealerName . '-individual-audit.pdf';

        $html = view('dealer.audit.individual.download', [
            'individualAudit' => $this->individualAudit
        ])->render();

        if(!File::isDirectory($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        $audit = Browsershot::html($html)
            ->showBackground()
            ->margins(10, 10, 10, 10)
            ->scale(0.75)
            ->waitUntilNetworkIdle()
            ->save(storage_path('app/individual-audits/' . $fileName));

        $updatePath = $this->individualAudit->update([
            'pdf_path' => $fileName,
        ]);
    }
}
