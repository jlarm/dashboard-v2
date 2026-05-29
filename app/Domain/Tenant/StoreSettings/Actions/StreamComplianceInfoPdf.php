<?php

declare(strict_types=1);

namespace App\Domain\Tenant\StoreSettings\Actions;

use App\Models\Dealer\Store;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;

class StreamComplianceInfoPdf
{
    public function handle(Store $store): PdfBuilder
    {
        $store->loadMissing('employeeList');
        $nodeBinary = $this->resolveNodeBinary();
        $filename = str($store->name)->slug()->toString().'-compliance-info-'.now()->format('Ymd').'.pdf';

        $footerHtml = '<div style="font-family: Arial, sans-serif; font-size: 9px; color: #9ca3af; width: 100%; padding: 0 14.82mm; box-sizing: border-box; display: flex; justify-content: space-between;">'
            .'<span>Automotive Risk Management Partners</span>'
            .'<span>Page <span class="pageNumber"></span> of <span class="totalPages"></span></span>'
            .'</div>';

        return Pdf::view('dealer.reports.compliance-info-pdf', [
            'store' => $store,
            'managers' => $store->employeeList,
            'generatedAt' => now(),
        ])
            ->format(Format::A4)
            ->margins(10.58, 14.82, 19, 14.82)
            ->name($filename)
            ->headerHtml('<span></span>')
            ->footerHtml($footerHtml)
            ->withBrowsershot(static fn (Browsershot $browsershot): Browsershot => $browsershot
                ->setNodeModulePath(base_path('node_modules'))
                ->setNodeBinary($nodeBinary)
                ->showBackground()
                ->waitUntilNetworkIdle()
            );
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
