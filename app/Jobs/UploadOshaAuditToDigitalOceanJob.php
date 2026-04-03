<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Dealer\Audit\OshaAudit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Throwable;

class UploadOshaAuditToDigitalOceanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected OshaAudit $oshaAudit) {}

    public function middleware(): array
    {
        return [new WithoutOverlapping(static::class.'-'.$this->oshaAudit->getKey())];
    }

    public function handle(): void
    {
        $pdf = Storage::get('/'.$this->oshaAudit->pdf_path);
        $moved = Storage::disk('do-audits')->put(tenant('id').'/osha/'.$this->oshaAudit->pdf_path, $pdf);
        if ($moved) {
            Storage::delete('/'.$this->oshaAudit->pdf_path);
        }
    }

    public function failed(?Throwable $exception): void
    {
        report_if($exception instanceof Throwable, $exception);
    }
}
