<?php

declare(strict_types=1);

namespace App\Jobs\Manuals;

use App\Models\Dealer\Manual\RedFlag;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Browsershot;
use Throwable;

class GenerateRedFlagManualJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected RedFlag $manual) {}

    public function handle(): void
    {
        $fileName = 'red-flags-manual-'.now()->format('YmdHis').'.pdf';
        $storagePath = storage_path('app/'.$fileName);

        $html = view('dealer.manual.pdf.red-flag', [
            'redFlag' => $this->manual,
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
        if ($exception !== null) {
            report($exception);
        }
    }
}
