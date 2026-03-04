<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Dealer\Audit\IndividualAudit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class UploadIndividualAuditToDigitalOceanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected IndividualAudit $individualAudit) {}

    public function middleware(): array
    {
        return [new WithoutOverlapping(static::class.'-'.$this->individualAudit->getKey())];
    }

    public function handle(): void
    {
        $pdf = Storage::get('/individual-audits/'.$this->individualAudit->pdf_path);
        $moved = Storage::disk('do-audits')->put(tenant('id').'/individual-audits/'.$this->individualAudit->pdf_path, $pdf);
        if ($moved) {
            Storage::delete('/individual-audits/'.$this->individualAudit->pdf_path);
        }
    }
}
