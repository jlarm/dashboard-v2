<?php

declare(strict_types=1);

namespace App\Jobs\Manuals;

use App\Models\Dealer\Manual\Isp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Throwable;

class GenerateIspManualJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected Isp $manual) {}

    public function handle(): void
    {
        $fileName = 'isp-manual-'.now()->format('YmdHis').'.pdf';
        $storagePath = storage_path('app/'.$fileName);
        $nodeBinary = $this->resolveNodeBinary();

        $footerHtml = '
             <div style="width: 100%; font-size: 10px; display: flex; justify-content: space-between; padding: 0 20px;">
                 <span>Automotive Risk Management Partners</span>
                 <span>Page <span class="pageNumber"></span></span>
             </div>
         ';

        Pdf::view('dealer.manual.pdf.isp', [
            'isp' => $this->manual,
        ])
            ->footerHtml($footerHtml)
            ->withBrowsershot(static fn (Browsershot $browsershot): Browsershot => $browsershot
                ->setNodeModulePath(base_path('node_modules'))
                ->setNodeBinary($nodeBinary)
                ->showBackground()
                ->margins(10, 10, 10, 10)
                ->scale(0.75)
                ->waitUntilNetworkIdle()
                ->showBrowserHeaderAndFooter()
                ->hideHeader()
            )
            ->save($storagePath);

        $this->manual->update([
            'pdf_path' => $fileName,
        ]);
    }

    public function failed(?Throwable $exception): void
    {
        if (! $exception instanceof Throwable) {
            return;
        }

        report($exception);
    }

    private function resolveNodeBinary(): string
    {
        $configured = config('services.browsershot.node_binary');

        if (is_string($configured) && $configured !== '' && File::exists($configured)) {
            return $configured;
        }

        foreach (['/opt/homebrew/bin/node', '/usr/local/bin/node'] as $candidate) {
            if (File::exists($candidate)) {
                return $candidate;
            }
        }

        $serverHome = Request::server('HOME');
        $home = is_string($serverHome) && $serverHome !== ''
            ? $serverHome
            : (string) (getenv('HOME') ?: '');
        if ($home !== '') {
            $herdNvm = $home.'/Library/Application Support/Herd/config/nvm/versions/node';
            if (is_dir($herdNvm)) {
                $versions = glob($herdNvm.'/v*/bin/node') ?: [];
                if ($versions !== []) {
                    rsort($versions);

                    return $versions[0];
                }
            }
        }

        return 'node';
    }
}
