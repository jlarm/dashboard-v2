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
use RuntimeException;
use Throwable;

class UploadBodyShopPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected BodyShopViolationAudit $bodyShopViolationAudit) {}

    public function middleware(): array
    {
        return [new WithoutOverlapping(static::class.'-'.$this->bodyShopViolationAudit->getKey())];
    }

    public function handle(): void
    {
        $localPath = '/bodyshop/'.$this->bodyShopViolationAudit->pdf_path;

        throw_unless(Storage::exists($localPath), new RuntimeException("Body Shop PDF not found at path: {$localPath}"));

        $stream = Storage::readStream($localPath);
        $path = tenant('id').'/bodyshop/'.$this->bodyShopViolationAudit->pdf_path;
        $moved = Storage::disk('armpaudits')->writeStream($path, $stream);

        if ($moved) {
            Storage::delete($localPath);
            $this->bodyShopViolationAudit->update(['pdf_path' => $path]);
        }
    }

    public function failed(?Throwable $exception): void
    {
        report_if($exception instanceof Throwable, $exception);
    }
}
