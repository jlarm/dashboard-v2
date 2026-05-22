<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Actions;

use App\Domain\Tenant\Compliance\Queries\BuildComplianceSummary;
use App\Models\Dealer\Store;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;

/**
 * Renders the executive-summary PDF via spatie/laravel-pdf. Returning a
 * PdfBuilder lets the controller stream it directly (Responsable) and lets
 * the queued mailer .save() it to disk for attachment without two code paths.
 */
class StreamComplianceSummaryPdf
{
    public function __construct(
        private readonly BuildComplianceSummary $buildSummary,
    ) {}

    /**
     * @param  Collection<int, Store>  $stores
     */
    public function handle(Collection $stores, string $reportPeriod, ?string $downloadName = null): PdfBuilder
    {
        $payload = $this->buildSummary->handle($stores, $reportPeriod);
        $filename = $downloadName ?? $this->buildFilename($stores);
        $nodeBinary = $this->resolveNodeBinary();

        $footerHtml = '<div style="font-family: Arial, sans-serif; font-size: 9px; color: #9ca3af; width: 100%; padding: 0 14.82mm; box-sizing: border-box; display: flex; justify-content: space-between;">'
            .'<span>Automotive Risk Management Partners</span>'
            .'<span>Page <span class="pageNumber"></span> of <span class="totalPages"></span></span>'
            .'</div>';

        return Pdf::view('dealer.reports.compliance-summary-pdf', $payload)
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

    /**
     * @param  Collection<int, Store>  $stores
     */
    private function buildFilename(Collection $stores): string
    {
        $slug = $stores->count() === 1
            ? str($stores->first()?->name)->slug()->toString()
            : 'overview';

        return now()->format('Ymd').'-'.$slug.'-audit-report.pdf';
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
