<?php

namespace App\Jobs;

use App\Models\Dealer\Audit\BodyShopAudit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class UploadBodyShopAuditToDigitalOceanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected BodyShopAudit $bodyShopAudit)
    {
    }

    public function handle(): void
    {
        $pdf = Storage::get('/body-shop-audits/' . $this->bodyShopAudit->pdf_path);
        $moved = Storage::disk('do-audits')->put(tenant('id') . '/audits/finance/' . $this->bodyShopAudit->pdf_path, $pdf);
        if($moved) {
            Storage::delete('/body-shop-audits/' . $this->bodyShopAudit->pdf_path);
        }
    }
}
