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
use RuntimeException;
use Throwable;

class UploadOshaPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected OshaViolationAudit $oshaViolationAudit) {}

    /**
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [new WithoutOverlapping(static::class.'-'.$this->oshaViolationAudit->getKey())];
    }

    public function handle(): void
    {
        if (app()->isLocal()) {
            return;
        }
        $localPath = '/osha/'.$this->oshaViolationAudit->pdf_path;

        throw_unless(Storage::exists($localPath), RuntimeException::class, "OSHA PDF not found at path: {$localPath}");

        $stream = Storage::readStream($localPath);
        throw_if($stream === null, RuntimeException::class, "Unable to read OSHA PDF at path: {$localPath}");
        $path = tenant('id').'/osha/'.$this->oshaViolationAudit->pdf_path;
        $moved = Storage::disk('armpaudits')->writeStream($path, $stream);

        if ($moved) {
            Storage::delete($localPath);
            $this->oshaViolationAudit->update(['pdf_path' => $path]);
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
