<?php

namespace App\Jobs;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\User;
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

    public int $timeout = 240;
    public $audits;
    public int $count = 0;

    public function __construct(protected IndividualAudit $individualAudit)
    {
        $this->audits = $this->individualAudit
            ->where('id', $this->individualAudit->id)
            ->orWhere('parent_id', $this->individualAudit->id)
            ->with('store')
            ->get();
    }

    public function handle(): void
    {
        $path = storage_path('app/individual-audits');
        if(!File::isDirectory($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        if(tenant('locations')){
            $dealerName = str_replace(' ', '-', $this->individualAudit->store->name);
        } else {
            $dealerName = str_replace(' ', '-', tenant('name'));
        }

        foreach ($this->audits as $audit) {
            $count = $this->count;
            $fileName = $audit->audit_date->format('Ymd') . '-' . $dealerName . '-' . $audit->customer_number . '-individual-audit.pdf';

            $html = view('dealer.audit.individual.download', [
                'individualAudit' => $audit,
                'count' => $count,
                'managerName' => isset($audit->manager_id) ? User::where('id', $audit->manager_id)->first()->name : null,
            ])->render();

            $pdf = Browsershot::html($html)
                ->showBackground()
                ->margins(10, 10, 10, 10)
                ->scale(0.75)
                ->waitUntilNetworkIdle()
                ->save(storage_path('app/individual-audits/' . $fileName));

            $updatePath = $audit->update([
                'pdf_path' => $fileName,
            ]);
            $this->count++;
        }

    }
}
