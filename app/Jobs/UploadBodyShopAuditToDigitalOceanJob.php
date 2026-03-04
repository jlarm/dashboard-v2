<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Dealer\Audit\BodyShopAudit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class UploadBodyShopAuditToDigitalOceanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected BodyShopAudit $bodyShopAudit) {}

    public function middleware(): array
    {
        return [new WithoutOverlapping(static::class.'-'.$this->bodyShopAudit->getKey())];
    }

    public function handle(): void
    {
        $pdf = Storage::get('/body-shop-audits/'.$this->bodyShopAudit->pdf_path);
        $moved = Storage::disk('do-audits')->put(tenant('id').'/body-shop/'.$this->bodyShopAudit->pdf_path, $pdf);
        if ($moved) {
            Storage::delete('/body-shop-audits/'.$this->bodyShopAudit->pdf_path);
        }
    }
}
