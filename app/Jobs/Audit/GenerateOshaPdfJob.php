<?php

namespace App\Jobs\Audit;

use App\Models\Dealer\Audit\OshaViolationAudit;
use File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Browsershot;

class GenerateOshaPdfJob implements ShouldBeEncrypted, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private OshaViolationAudit $oshaViolationAudit)
    {
    }

    public function middleware(): array
    {
        return [new WithoutOverlapping($this->oshaViolationAudit)];
    }

    private function rating(): string
    {
        $violationCount = $this->oshaViolationAudit->violations->count();

        if ($violationCount >= 0 && $violationCount <= 10) {
            return 'A';
        } elseif ($violationCount >= 11 && $violationCount <= 20) {
            return 'B';
        } elseif ($violationCount >= 21 && $violationCount <= 30) {
            return 'C';
        } elseif ($violationCount >= 31 && $violationCount <= 40) {
            return 'D';
        } elseif ($violationCount >= 41 && $violationCount <= 50) {
            return 'F';
        }
    }

    public function handle(): void
    {
        $path = $this->createDirectory();
        $fileName = $this->createFileName();
        $this->createPdf($path, $fileName);
        $this->updateAudit($fileName);
    }

    private function createDirectory(): string
    {
        $path = storage_path('app/osha');

        if (! File::isDirectory($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        return $path;
    }

    private function createFileName(): string
    {
        if (tenant('locations')) {
            $dealerName = str_replace(' ', '-', $this->oshaViolationAudit->store->name);
        } else {
            $dealerName = str_replace(' ', '-', tenant('name'));
        }

        return $this->oshaViolationAudit->uuid.'-'.$dealerName.'-'.now()->format('Ymd').'-osha-violation-audit.pdf';
    }

    private function createPdf(string $path, string $fileName): void
    {
        $directoryPath = dirname($path.'/'.$fileName);

        if (! File::isDirectory($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true, true);
        }

        $html = view('dealer.audit.osha.pdf-view', [
            'fileName' => $fileName,
            'audit' => $this->oshaViolationAudit,
        ])->render();

        $footer = view('pdf.audit-footer')->render();

        Browsershot::html($html)
            ->showBackground()
            ->format('A4')
            ->scale(0.75)
            ->waitUntilNetworkIdle()
            ->showBrowserHeaderAndFooter()
            ->hideHeader()
            ->footerHtml($footer)
            ->save($path.'/'.$fileName);
    }

    private function updateAudit(string $fileName): void
    {
        $this->oshaViolationAudit->update([
            'pdf_path' => $fileName,
            'grade' => $this->rating(),
        ]);
    }
}
