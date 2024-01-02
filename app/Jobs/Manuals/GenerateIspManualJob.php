<?php

namespace App\Jobs\Manuals;

use App\Models\Dealer\Manual\Isp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Browsershot;

class GenerateIspManualJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected Isp $manual)
    {
    }

    public function handle(): void
    {
        $fileName = 'isp-manual-'.now()->format('YmdHis').'.pdf';
        $storagePath = storage_path('app/'.$fileName);

        $html = view('dealer.manual.pdf.isp', [
            'isp' => $this->manual,
        ])->render();

        $manual = Browsershot::html($html)
            ->showBackground()
            ->margins(10, 10, 10, 10)
            ->scale(0.75)
            ->waitUntilNetworkIdle()
            ->save($storagePath);

        $updatePath = $this->manual->update([
            'pdf_path' => $fileName,
        ]);
    }
}
