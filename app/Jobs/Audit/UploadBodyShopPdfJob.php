<?php

declare(strict_types=1);

namespace App\Jobs\Audit;

use App\Models\Dealer\Audit\BodyShopViolationAudit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class UploadBodyShopPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected BodyShopViolationAudit $bodyShopViolationAudit) {}

    public function middleware(): array
    {
        return [new WithoutOverlapping($this->bodyShopViolationAudit)];
    }

    public function handle(): void
    {
        $pdf = Storage::get('/bodyshop/'.$this->bodyShopViolationAudit->pdf_path);
        $path = tenant('id').'/bodyshop/'.$this->bodyShopViolationAudit->pdf_path;
        $move = Storage::disk('armpaudits')->put(tenant('id').'/bodyshop/'.$this->bodyShopViolationAudit->pdf_path, $pdf);
        if ($move) {
            Storage::delete('/bodyshop/', $this->bodyShopViolationAudit->pdf_path);
            $this->bodyShopViolationAudit->update(['pdf_path' => $path]);
        }
    }
}
