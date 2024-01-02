<?php

namespace App\Jobs;

use App\Models\Dealer\Audit\BodyShopAudit;
use File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Browsershot;

class GenerateBodyShopAuditPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected BodyShopAudit $bodyShopAudit)
    {
    }

    private function rating(): float
    {
        $sum = 0;
        for ($i = 1; $i <= 43; $i++) {
            if ($this->bodyShopAudit->{'body_shop_q'.$i.'_answer'} == 2) {
                $sum += 1;
            }
        }

        $wrong = $sum;

        return number_format(100 * (43 - $wrong) / 43, 2, '.', '');
    }

    public function handle(): void
    {
        $path = storage_path('app/body-shop-audits');
        if (tenant('locations')) {
            $dealerName = str_replace(' ', '-', $this->bodyShopAudit->store->name);
        } else {
            $dealerName = str_replace(' ', '-', tenant('name'));
        }
        $fileName = $this->bodyShopAudit->audit_date->format('Ymd').'-'.$dealerName.'-body-shop-audit.pdf';

        if (! File::isDirectory($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        $html = view('dealer.audit.body-shop.download', [
            'audit' => $this->bodyShopAudit,
        ])->render();

        $audit = Browsershot::html($html)
            ->showBackground()
            ->format('A4')
            ->scale(0.75)
            ->waitUntilNetworkIdle()
            ->save(storage_path('app/body-shop-audits/'.$fileName));

        $updatePath = $this->bodyShopAudit->update([
            'pdf_path' => $fileName,
            'rating' => $this->rating(),
        ]);

    }
}
