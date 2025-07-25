<?php

namespace App\Jobs\Audit;

use App\Models\Dealer\Audit\GlbaViolationAudit;
use File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Browsershot;

class GenerateGlbaPdfJob implements ShouldBeEncrypted, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly GlbaViolationAudit $glbaViolationAudit) {}

    public function middleware(): array
    {
        return [new WithoutOverlapping($this->glbaViolationAudit)];
    }

    private function rating(): string
    {
        $violationCount = $this->glbaViolationAudit->violations->count();

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
        $path = storage_path('app/glba');

        if (! File::isDirectory($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        return $path;
    }

    private function createFileName(): string
    {
        if (tenant('locations')) {
            $dealerName = str_replace(' ', '-', $this->glbaViolationAudit->store->name);
        } else {
            $dealerName = str_replace(' ', '-', tenant('name'));
        }

        return $this->glbaViolationAudit->uuid.'-'.$dealerName.'-'.now()->format('Ymd').'-glba-violation-audit.pdf';
    }

    private function createPdf(string $path, string $fileName): void
    {
        $html = view('dealer.audit.finance.pdf-view', [
            'fileName' => $fileName,
            'audit' => $this->glbaViolationAudit,
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
            ->save(storage_path('app/glba/'.$fileName));
    }

    private function updateAudit(string $fileName): void
    {
        $this->glbaViolationAudit->update([
            'pdf_path' => $fileName,
            'grade' => $this->rating(),
        ]);
    }
}
