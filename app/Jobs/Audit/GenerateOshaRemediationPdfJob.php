<?php

declare(strict_types=1);

namespace App\Jobs\Audit;

use Illuminate\Support\Facades\Log;
use App\Models\Dealer\Audit\OshaViolationAudit;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class GenerateOshaRemediationPdfJob implements ShouldBeEncrypted, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly OshaViolationAudit $oshaViolationAudit,
    ) {}

    public function middleware(): array
    {
        return [new WithoutOverlapping($this->oshaViolationAudit)];
    }

    public function handle(): void
    {
        try {
            $fileName = $this->createFileName();
            $this->generatePdf($fileName);

            $doPath = tenant('id').'/osha/'.$fileName;

            $relativePath = 'temp/'.$fileName;

            throw_unless(Storage::disk('local')->exists($relativePath), new Exception("File not found at path: {$relativePath}"));

            $contents = Storage::disk('local')->get($relativePath);

            throw_if($contents === null, new Exception("Failed to retrieve contents from: {$relativePath}"));

            Storage::disk('armpaudits')->put($doPath, $contents);

            Storage::disk('local')->delete($relativePath);

            $this->oshaViolationAudit->update([
                'remediation_pdf_path' => $doPath,
            ]);
        } catch (Exception $e) {
            Log::error('PDF Generation Failed: '.$e->getMessage());
        }
    }

    private function createFileName(): string
    {
        $dealerName = tenant('locations')
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

        $html = view('dealer.audit.osha.pdf-view', [
            'fileName' => $fileName,
            'audit' => $this->oshaViolationAudit,
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
