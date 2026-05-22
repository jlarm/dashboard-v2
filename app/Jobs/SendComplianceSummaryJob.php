<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Domain\Tenant\Compliance\Actions\StreamComplianceSummaryPdf;
use App\Mail\ComplianceSummaryMail;
use App\Models\Dealer\Store;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendComplianceSummaryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param  array<int>  $storeIds  IDs of all stores to include in the report
     * @param  array<string>  $recipientEmails
     * @param  string  $reportPeriod  Human-readable period label, e.g. "April 2026"
     */
    public function __construct(
        public readonly array $storeIds,
        private readonly array $recipientEmails,
        private readonly string $reportPeriod,
    ) {}

    public function handle(StreamComplianceSummaryPdf $streamSummary): void
    {
        $stores = Store::query()->whereIn('id', $this->storeIds)->get();

        $directory = storage_path('app/compliance-summary');

        if (! File::isDirectory($directory)) {
            File::makeDirectory($directory, 0777, true, true);
        }

        $pdfPath = $directory.'/'.implode('-', array_filter([
            tenant('id'),
            now()->format('Ymd-His'),
            'compliance-summary',
        ])).'.pdf';

        $streamSummary->handle($stores, $this->reportPeriod)->save($pdfPath);

        try {
            $tenantName = (string) tenant('name');
            $reportTitle = $stores->count() === 1 ? (string) $stores->first()?->name : $tenantName;

            Mail::to($this->recipientEmails)->send(
                new ComplianceSummaryMail($reportTitle, $this->reportPeriod, $pdfPath)
            );
        } finally {
            File::delete($pdfPath);
        }
    }

    public function failed(?Throwable $exception): void
    {
        if (! $exception instanceof Throwable) {
            return;
        }

        report($exception);
    }
}
