<?php

declare(strict_types=1);

namespace App\Jobs\Audit;

use App\Models\BodyShopViolationStatement;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
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
        $this->createDirectory();
        $fileName = $this->createFileName();
        $this->createPdf($fileName);
        $this->updateAudit($fileName);
    }

    private function rating(): string
    {
        $violations = $this->bodyShopViolationAudit->violations()->get();

        if ($violations->isEmpty()) {
            return 'A';
        }

        $statementIds = $violations->pluck('statement_id')->filter()->unique();
        $statements = tenancy()->central(fn () => BodyShopViolationStatement::query()->whereIn('id', $statementIds)->get()->keyBy('id'));

        $totalPotentialWeight = $violations->sum(fn ($v) => $statements->get($v->statement_id)?->weight ?? 1);
        $totalPenalty = $violations->sum(function ($v) use ($statements): int|float {
            $weight = $statements->get($v->statement_id)?->weight ?? 1;
            $effectiveWeight = ($v->risk ?? false) ? ($weight * 3) : $weight;

            return $effectiveWeight * (($v->severity ?? 1) / 10);
        });

        $actualScore = $totalPotentialWeight - $totalPenalty;
        $finalPercentage = ($actualScore / $totalPotentialWeight) * 100;

        if ($finalPercentage >= 90) {
            return 'A';
        }
        if ($finalPercentage >= 80) {
            return 'B';
        }
        if ($finalPercentage >= 70) {
            return 'C';
        }
        if ($finalPercentage >= 60) {
            return 'D';
        }

        return 'F';
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

    private function createPdf(string $fileName): void
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
