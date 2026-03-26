<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Store;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Spatie\Browsershot\Browsershot;
use Throwable;

class GenerateOshaAuditJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly OshaAudit $oshaAudit) {}

    public function handle(): void
    {
        $path = storage_path('app/osha');
        if ($this->oshaAudit->store !== null && Store::query()->count() > 1) {
            $dealerName = str_replace(' ', '-', $this->oshaAudit->store->name);
        } else {
            $dealerName = str_replace(' ', '-', tenant('name'));
        }
        $fileName = $this->oshaAudit->audit_date->format('Ymd').'-'.$this->oshaAudit->created_at->format('his').'-'.$dealerName.'-osha-audit.pdf';

        if (! File::isDirectory($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        $html = view('dealer.audit.osha.download', [
            'audit' => $this->oshaAudit->load(['violations', 'auditComments']),
        ])->render();

        $footer = view('pdf.audit-footer')->render();

        Browsershot::html($html)
            ->showBackground()
            ->format('A4')
            ->scale(0.75)
            ->waitUntilNetworkIdle()
            ->showBrowserHeaderAndFooter()
            ->hideHeader()
            ->footerHtml($footer)
            ->save(storage_path('app/'.$fileName));

        $this->oshaAudit->update([
            'pdf_path' => $fileName,
            'rating' => $this->rating(),
        ]);
    }

    public function failed(?Throwable $exception): void
    {
        if ($exception !== null) {
            report($exception);
        }
    }

    private function rating(): float
    {
        $sum = 0;
        $exclude = [7, 21, 62];
        for ($i = 1; $i <= 65; $i++) {
            if (! in_array($i, $exclude) && $this->oshaAudit->{'osha_q'.$i.'_answer'} === 2) {
                $sum += 1;
            }
        }

        $wrong = $sum;

        return (float) number_format(100 * (62 - $wrong) / 62, 2, '.', '');
    }
}
