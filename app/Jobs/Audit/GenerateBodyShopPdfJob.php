<?php

declare(strict_types=1);

namespace App\Jobs\Audit;

use App\Models\Dealer\Audit\BodyShopViolationAudit;
use File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Browsershot;

class GenerateBodyShopPdfJob implements ShouldBeEncrypted, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly BodyShopViolationAudit $bodyShopViolationAudit) {}

    public function middleware(): array
    {
        return [new WithoutOverlapping($this->bodyShopViolationAudit)];
    }

    public function handle(): void
    {
        $path = $this->createDirectory();
        $fileName = $this->createFileName();
        $this->createPdf($path, $fileName);
        $this->updateAudit($fileName);
    }

    private function rating(): string
    {
        $violationCount = $this->bodyShopViolationAudit->violations->count();

        if ($violationCount >= 0 && $violationCount <= 10) {
            return 'A';
        }
        if ($violationCount >= 11 && $violationCount <= 20) {
            return 'B';
        }
        if ($violationCount >= 21 && $violationCount <= 30) {
            return 'C';
        }
        if ($violationCount >= 31 && $violationCount <= 40) {
            return 'D';
        }
        if ($violationCount >= 41 && $violationCount <= 50) {
            return 'F';
        }

        return '';
    }

    private function createDirectory(): string
    {
        $path = storage_path('app/bodyshop');

        if (! File::isDirectory($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        return $path;
    }

    private function createFileName(): string
    {
        if (tenant('locations')) {
            $dealerName = str_replace(' ', '-', $this->bodyShopViolationAudit->store->name);
        } else {
            $dealerName = str_replace(' ', '-', tenant('name'));
        }

        return $this->bodyShopViolationAudit->uuid.'-'.$dealerName.'-'.now()->format('Ymd').'-bodyshop-violation-audit.pdf';
    }

    private function createPdf(string $path, string $fileName): void
    {
        $html = view('dealer.audit.body-shop.pdf-view', [
            'fileName' => $fileName,
            'audit' => $this->bodyShopViolationAudit->load(['violations', 'auditComments']),
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
            ->save(storage_path('app/bodyshop/'.$fileName));
    }

    private function updateAudit(string $fileName): void
    {
        $this->bodyShopViolationAudit->update([
            'pdf_path' => $fileName,
            'grade' => $this->rating(),
        ]);
    }
}
