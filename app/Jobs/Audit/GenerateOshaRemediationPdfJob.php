<?php

declare(strict_types=1);

namespace App\Jobs\Audit;

use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Facades\Pdf;
use Throwable;

class GenerateOshaRemediationPdfJob implements ShouldBeEncrypted, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly OshaViolationAudit $oshaViolationAudit,
    ) {}

    public function middleware(): array
    {
        return [new WithoutOverlapping(static::class.'-'.$this->oshaViolationAudit->getKey())];
    }

    public function handle(): void
    {
        try {
            $fileName = $this->createFileName();
            $this->generatePdf($fileName);

            $doPath = tenant('id').'/osha/'.$fileName;

            $relativePath = 'temp/'.$fileName;

            throw_unless(Storage::disk('local')->exists($relativePath), Exception::class, "File not found at path: {$relativePath}");

            $contents = Storage::disk('local')->get($relativePath);

            throw_if($contents === null, Exception::class, "Failed to retrieve contents from: {$relativePath}");

            Storage::disk('armpaudits')->put($doPath, $contents);

            Storage::disk('local')->delete($relativePath);

            $this->oshaViolationAudit->update([
                'remediation_pdf_path' => $doPath,
            ]);
        } catch (Exception $e) {
            Log::error('PDF Generation Failed: '.$e->getMessage());
        }
    }

    public function failed(?Throwable $exception): void
    {
        report_if($exception instanceof Throwable, $exception);
    }

    private function createFileName(): string
    {
        $dealerName = Store::query()->count() > 1
            ? str_replace(' ', '-', $this->oshaViolationAudit->store->name)
            : str_replace(' ', '-', tenant('name'));

        return mb_strtolower($dealerName).'-'.now()->format('Ymd').'-osha-violation-audit-remediation.pdf';
    }

    private function generatePdf(string $fileName): string
    {
        $tempDirectory = storage_path('app/temp');

        if (! file_exists($tempDirectory)) {
            mkdir($tempDirectory, 0755, true);
        }

        $localPath = $tempDirectory.'/'.$fileName;

        Pdf::view('dealer.audit.osha.pdf-view', [
            'fileName' => $fileName,
            'audit' => $this->oshaViolationAudit,
            'remediation' => true,
        ])
            ->driver('browsershot')
            ->format(Format::A4)
            ->withBrowsershot(static fn (Browsershot $browsershot) => $browsershot
                ->showBackground()
                ->scale(0.75)
                ->waitUntilNetworkIdle()
                ->hideHeader()
                ->hideFooter()
            )
            ->save($localPath);

        return $localPath;
    }
}
