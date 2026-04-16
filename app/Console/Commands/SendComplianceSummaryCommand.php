<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\ComplianceSummaryFrequency;
use App\Jobs\SendComplianceSummaryJob;
use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class SendComplianceSummaryCommand extends Command
{
    protected $signature = 'compliance-summary:send {--tenants=* : The tenant(s) to run for. Default all.}';
    protected $description = 'Send automated compliance summary emails to configured recipients.';

    public function handle(): void
    {
        /** @var Collection<int, string> $tenants */
        $tenants = collect($this->option('tenants'))
            ->filter(static fn (mixed $t): bool => is_string($t) && $t !== '')
            ->values();

        tenancy()->runForMultiple($tenants->isEmpty() ? null : $tenants, function (): void {
            $this->processTenant();
        });
    }

    private function processTenant(): void
    {
        $settings = GlobalSetting::query()->first();

        if (! $settings?->compliance_summary_active) {
            return;
        }

        $frequency = $settings->compliance_summary_frequency;

        if (! $frequency instanceof ComplianceSummaryFrequency) {
            return;
        }

        if (! $frequency->isDueToday()) {
            return;
        }

        $recipientIds = $settings->compliance_summary_recipients ?? [];

        if (empty($recipientIds)) {
            return;
        }

        $recipientEmails = User::query()
            ->whereIn('id', $recipientIds)
            ->pluck('email')
            ->all();

        if (empty($recipientEmails)) {
            return;
        }

        $reportPeriod = $frequency->periodLabel();

        $storeIds = Store::query()->pluck('id')->all();

        SendComplianceSummaryJob::dispatch($storeIds, $recipientEmails, $reportPeriod);
    }
}
