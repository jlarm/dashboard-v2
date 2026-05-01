<?php

declare(strict_types=1);

namespace App\Jobs\Audit;

use App\Models\Dealer\Audit\BodyShopViolationAudit;
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

class GenerateBodyShopRemediationPdfJob implements ShouldBeEncrypted, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly BodyShopViolationAudit $bodyShopViolationAudit,
    ) {}

    public function middleware(): array
    {
        return [new WithoutOverlapping(static::class.'-'.$this->bodyShopViolationAudit->getKey())];
    }

    public function handle(): void
    {
        Log::info('Start generating body shop remediation pdf');
        try {
            $fileName = $this->createFileName();
            $this->generatePdf($fileName);

            $doPath = tenant('id').'/body-shop/'.$fileName;

            $relativePath = 'temp/'.$fileName;

            throw_unless(Storage::disk('local')->exists($relativePath), Exception::class, "File not found at path: {$relativePath}");

            $contents = Storage::disk('local')->get($relativePath);

            throw_if($contents === null, Exception::class, "Failed to retrieve contents from: {$relativePath}");

            Storage::disk('armpaudits')->put($doPath, $contents);

            Storage::disk('local')->delete($relativePath);

            $this->bodyShopViolationAudit->update([
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
            ? str_replace(' ', '-', $this->bodyShopViolationAudit->store->name)
            : str_replace(' ', '-', tenant('name'));

        return mb_strtolower($dealerName).'-'.now()->format('Ymd').'-body-shop-violation-audit-remediation.pdf';
    }

    private function generatePdf(string $fileName): string
    {
        $tempDirectory = storage_path('app/temp');

        if (! file_exists($tempDirectory)) {
            mkdir($tempDirectory, 0755, true);
        }

        $localPath = $tempDirectory.'/'.$fileName;

        Pdf::view('dealer.audit.body-shop.pdf-view', [
            'fileName' => $fileName,
            'audit' => $this->bodyShopViolationAudit,
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
