<?php

declare(strict_types=1);

namespace App\Jobs\Manuals;

use App\Models\CmsManual;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Throwable;
use Webklex\PDFMerger\Facades\PDFMergerFacade;

class GenerateCmsManualJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected CmsManual $manual) {}

    public function handle(): void
    {
        $fileName = 'cms-manual-'.now()->format('YmdHis').'.pdf';
        $storagePath = storage_path('app/'.$fileName);
        $nodeBinary = $this->resolveNodeBinary();
        $storeName = e((string) $this->manual->store?->name);

        // Render cover and body as two separate PDFs, then merge them. Keeps
        // the cover free of header/footer while letting the body restart page
        // numbering at 1 (Chrome PDF header templates can't gate via JS).
        $coverPath = storage_path('app/temp-'.Str::uuid().'-cover.pdf');
        $bodyPath = storage_path('app/temp-'.Str::uuid().'-body.pdf');

        try {
            $this->renderCover($coverPath, $nodeBinary);
            $this->renderBody($bodyPath, $nodeBinary, $storeName);
            $this->mergeInto($storagePath, $coverPath, $bodyPath);

            $this->manual->update(['pdf_path' => $fileName]);
        } finally {
            File::delete([$coverPath, $bodyPath]);
        }
    }

    public function failed(?Throwable $exception): void
    {
        if (! $exception instanceof Throwable) {
            return;
        }

        report($exception);
    }

    private function renderCover(string $path, string $nodeBinary): void
    {
        Pdf::view('dealer.manual.pdf.cms', [
            'cms' => $this->manual,
            'variant' => 'cover',
        ])
            ->driver('browsershot')
            ->withBrowsershot(static fn (Browsershot $browsershot): Browsershot => $browsershot
                ->setNodeModulePath(base_path('node_modules'))
                ->setNodeBinary($nodeBinary)
                ->showBackground()
                ->margins(10, 10, 10, 10)
                ->scale(0.75)
                ->waitUntilNetworkIdle()
            )
            ->save($path);
    }

    private function renderBody(string $path, string $nodeBinary, string $storeName): void
    {
        Pdf::view('dealer.manual.pdf.cms', [
            'cms' => $this->manual,
            'variant' => 'body',
        ])
            ->driver('browsershot')
            ->headerHtml($this->headerHtml($storeName, 'Compliance Management System'))
            ->footerHtml($this->footerHtml())
            ->withBrowsershot(static fn (Browsershot $browsershot): Browsershot => $browsershot
                ->setNodeModulePath(base_path('node_modules'))
                ->setNodeBinary($nodeBinary)
                ->showBackground()
                ->margins(15, 10, 15, 10)
                ->scale(0.75)
                ->waitUntilNetworkIdle()
            )
            ->save($path);
    }

    private function mergeInto(string $finalPath, string ...$parts): void
    {
        $merger = PDFMergerFacade::init();
        foreach ($parts as $part) {
            $merger->addPDF($part, 'all');
        }
        $merger->merge();
        $merger->save($finalPath);
    }

    private function headerHtml(string $storeName, string $manualTitle): string
    {
        // Chrome PDF header/footer templates don't execute scripts; use static
        // substitution like the exec summary and audit PDFs.
        return '<div style="width: 100%; font-size: 9px; color: #6b7280; padding: 0 0.5in; '
            .'display: flex; justify-content: space-between; align-items: center;">'
            .'<span>'.$storeName.'</span>'
            .'<span>'.e($manualTitle).'</span>'
            .'</div>';
    }

    private function footerHtml(): string
    {
        return '<div style="width: 100%; font-size: 9px; color: #6b7280; padding: 0 0.5in; '
            .'display: flex; justify-content: space-between; align-items: center;">'
            .'<span>Automotive Risk Management Partners</span>'
            .'<span>Page <span class="pageNumber"></span> of <span class="totalPages"></span></span>'
            .'</div>';
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
