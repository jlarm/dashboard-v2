<?php

declare(strict_types=1);

namespace App\Jobs\Audit;

use App\Models\Dealer\Audit\OshaViolationAudit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Throwable;

class UploadOshaPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected OshaViolationAudit $oshaViolationAudit) {}

    public function middleware(): array
    {
        return [new WithoutOverlapping(static::class.'-'.$this->oshaViolationAudit->getKey())];
    }

    public function handle(): void
    {
        if (app()->isLocal()) {
            return;
        }
        $pdf = Storage::get('/osha/'.$this->oshaViolationAudit->pdf_path);
        $path = tenant('id').'/osha/'.$this->oshaViolationAudit->pdf_path;
        $move = Storage::disk('armpaudits')->put(tenant('id').'/osha/'.$this->oshaViolationAudit->pdf_path, $pdf);
        if ($move) {
            Storage::delete('/osha/');
            $this->oshaViolationAudit->update(['pdf_path' => $path]);
        }
    }

    public function failed(?Throwable $exception): void
    {
        report_if($exception instanceof Throwable, $exception);
    }
}
