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
use Throwable;

class UploadIndividualAuditToDigitalOceanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected IndividualAudit $individualAudit) {}

    /**
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [new WithoutOverlapping(static::class.'-'.$this->individualAudit->getKey())];
    }

    public function handle(): void
    {
        $pdf = Storage::get('/individual-audits/'.$this->individualAudit->pdf_path);
        if ($pdf === null) {
            return;
        }
        $moved = Storage::disk('do-audits')->put(tenant('id').'/individual-audits/'.$this->individualAudit->pdf_path, $pdf);
        if ($moved) {
            Storage::delete('/individual-audits/'.$this->individualAudit->pdf_path);
        }
    }

    public function failed(?Throwable $exception): void
    {
        if (! $exception instanceof Throwable) {
            return;
        }

        report($exception);
    }
}
