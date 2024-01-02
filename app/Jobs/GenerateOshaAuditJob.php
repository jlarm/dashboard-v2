<?php

namespace App\Jobs;

use App\Models\Dealer\Audit\OshaAudit;
use File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Browsershot;

class GenerateOshaAuditJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private OshaAudit $oshaAudit)
    {
    }

    private function rating(): float
    {
        $sum = 0;
        $exclude = [7, 21, 62];
        for ($i = 1; $i <= 65; $i++) {
            if (! in_array($i, $exclude) && $this->oshaAudit->{'osha_q'.$i.'_answer'} == 2) {
                $sum += 1;
            }
        }

        $wrong = $sum;

        return number_format(100 * (62 - $wrong) / 62, 2, '.', '');
    }

    public function handle(): void
    {
        $path = storage_path('app/osha');
        if (tenant('locations')) {
            $dealerName = str_replace(' ', '-', $this->oshaAudit->store->name);
        } else {
            $dealerName = str_replace(' ', '-', tenant('name'));
        }
        $fileName = $this->oshaAudit->audit_date->format('Ymd').'-'.$this->oshaAudit->created_at->format('his').'-'.$dealerName.'-osha-audit.pdf';

        if (! File::isDirectory($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        $html = view('dealer.audit.osha.download', [
            'audit' => $this->oshaAudit,
        ])->render();

        $footer = view('pdf.audit-footer')->render();

        $audit = Browsershot::html($html)
            ->showBackground()
            ->format('A4')
            ->scale(0.75)
            ->waitUntilNetworkIdle()
            ->showBrowserHeaderAndFooter()
            ->hideHeader()
            ->footerHtml($footer)
            ->save(storage_path('app/'.$fileName));

        $updatePath = $this->oshaAudit->update([
            'pdf_path' => $fileName,
            'rating' => $this->rating(),
        ]);
    }
}
