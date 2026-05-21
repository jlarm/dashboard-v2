<?php

declare(strict_types=1);

namespace App\Jobs\Manuals;

use App\Models\CmsManual;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Throwable;

class UploadCmsToDigitalOceanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected CmsManual $manual) {}

    /**
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [new WithoutOverlapping(static::class.'-'.$this->manual->getKey())];
    }

    public function handle(): void
    {
        $pdf = Storage::get('/'.$this->manual->pdf_path);
        $moved = Storage::disk('do-manuals')->put(tenant('id').'/cms/'.$this->manual->pdf_path, $pdf);
        if ($moved) {
            Storage::delete('/'.$this->manual->pdf_path);
        }
    }

    public function failed(?Throwable $exception): void
    {
        report_if($exception instanceof Throwable, $exception);
    }
}
