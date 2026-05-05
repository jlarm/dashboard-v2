<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Queries;

use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use App\Models\Dealer\Violation;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CalculateOverdueRemediations
{
    private const int HIGH_SEVERITY_THRESHOLD = 8;

    /**
     * @var array<int, class-string<Model>>
     */
    private const array AUDIT_CLASSES = [
        OshaViolationAudit::class,
        BodyShopViolationAudit::class,
        GlbaViolationAudit::class,
    ];

    /**
     * Count overdue remediation violations for a store as of $now.
     *
     * Overdue = audit has completed_date, no remediation_pdf_path, and the
     * grace window (completed_date + RemediationSetting.frequency days) has
     * already passed. Stores without a RemediationSetting are skipped.
     *
     * @return array{count:int, high_severity_count:int}
     */
    public function handle(Store $store, ?CarbonImmutable $now = null): array
    {
        $now ??= CarbonImmutable::now();

        $store->loadMissing('remediationSettings');
        $setting = $store->remediationSettings;

        if ($setting === null) {
            return ['count' => 0, 'high_severity_count' => 0];
        }

        $cutoff = $now->subDays($setting->frequency->value())->toDateString();

        $count = 0;
        $highSeverityCount = 0;

        foreach (self::AUDIT_CLASSES as $auditClass) {
            $overdueAuditIds = $this->overdueAuditIds($auditClass, $store->id, $cutoff);

            if ($overdueAuditIds === []) {
                continue;
            }

            $morphType = (new $auditClass)->getMorphClass();

            $severities = Violation::query()
                ->where('violationable_type', $morphType)
                ->whereIn('violationable_id', $overdueAuditIds)
                ->whereDoesntHave('remediation', fn (Builder $q) => $q->where('completed', true))
                ->pluck('severity');

            foreach ($severities as $severity) {
                $count++;
                if ((int) $severity >= self::HIGH_SEVERITY_THRESHOLD) {
                    $highSeverityCount++;
                }
            }
        }

        return ['count' => $count, 'high_severity_count' => $highSeverityCount];
    }

    /**
     * @param  class-string<Model>  $auditClass
     * @return array<int, int>
     */
    private function overdueAuditIds(string $auditClass, int $storeId, string $cutoffDate): array
    {
        /** @var Builder<Model> $query */
        $query = $auditClass::query();

        return $query
            ->where('store_id', $storeId)
            ->whereNotNull('completed_date')
            ->whereNull('remediation_pdf_path')
            ->whereDate('completed_date', '<', $cutoffDate)
            ->pluck('id')
            ->map(static fn ($id): int => (int) $id)
            ->all();
    }
}
