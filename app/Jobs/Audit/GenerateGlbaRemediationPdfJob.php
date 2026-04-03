<?php

declare(strict_types=1);

namespace App\Jobs\Audit;

use App\Models\Dealer\Audit\GlbaViolationAudit;
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
use Throwable;

class GenerateGlbaRemediationPdfJob implements ShouldBeEncrypted, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly GlbaViolationAudit $glbaViolationAudit,
    ) {}

    public function middleware(): array
    {
        return [new WithoutOverlapping(static::class.'-'.$this->glbaViolationAudit->getKey())];
    }

    public function handle(): void
    {
        try {
            $fileName = $this->createFileName();
            $this->generatePdf($fileName);

            $doPath = tenant('id').'/glba/'.$fileName;

            $relativePath = 'temp/'.$fileName;

            throw_unless(Storage::disk('local')->exists($relativePath), new Exception("File not found at path: {$relativePath}"));

            $contents = Storage::disk('local')->get($relativePath);

            throw_if($contents === null, new Exception("Failed to retrieve contents from: {$relativePath}"));

            Storage::disk('armpaudits')->put($doPath, $contents);

            Storage::disk('local')->delete($relativePath);

            $this->glbaViolationAudit->update([
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
            ? str_replace(' ', '-', $this->glbaViolationAudit->store->name)
            : str_replace(' ', '-', tenant('name'));

        return mb_strtolower($dealerName).'-'.now()->format('Ymd').'-glba-violation-audit-remediation.pdf';
    }

    private function generatePdf(string $fileName): string
    {
        $tempDirectory = storage_path('app/temp');

        if (! file_exists($tempDirectory)) {
            mkdir($tempDirectory, 0755, true);
        }

        $localPath = $tempDirectory.'/'.$fileName;

        $html = view('dealer.audit.finance.pdf-view', [
            'fileName' => $fileName,
            'audit' => $this->glbaViolationAudit,
            'remediation' => true,
        ])->render();

        Browsershot::html($html)
            ->showBackground()
            ->format('A4')
            ->scale(0.75)
            ->waitUntilNetworkIdle()
            ->hideHeader()
            ->hideFooter()
            ->save($localPath);

        return $localPath;
    }
}
