<?php

declare(strict_types=1);

namespace App\Jobs\Manuals;

use App\Models\CmsManual;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Browsershot;
use Throwable;

class GenerateCmsManualJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected CmsManual $manual) {}

    public function handle(): void
    {
        $fileName = 'cms-manual-'.now()->format('YmdHis').'.pdf';
        $storagePath = storage_path('app/'.$fileName);

        $html = view('dealer.manual.pdf.cms', [
            'cms' => $this->manual,
        ])->render();

        Browsershot::html($html)
            ->showBackground()
            ->margins(10, 10, 10, 10)
            ->scale(0.75)
            ->waitUntilNetworkIdle()
            ->save($storagePath);

        $this->manual->update([
            'pdf_path' => $fileName,
        ]);
    }

    public function failed(?Throwable $exception): void
    {
        report_if($exception instanceof Throwable, $exception);
    }
}
