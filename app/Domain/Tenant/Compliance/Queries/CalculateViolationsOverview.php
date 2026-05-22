<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Queries;

use App\Domain\Tenant\Compliance\Data\ViolationsOverviewData;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Remediation;
use Carbon\CarbonImmutable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CalculateViolationsOverview
{
    private const int PERIODS = 6;

    /**
     * @var array<int, class-string<ViolationAudit&Model>>
     */
    private const array AUDIT_CLASSES = [
        OshaViolationAudit::class,
        BodyShopViolationAudit::class,
        GlbaViolationAudit::class,
    ];

    /**
     * Build the last six monthly, quarterly, and yearly buckets of violations
     * "opened" (audit completed in the bucket) and "closed" (remediation
     * completed in the bucket) across the given stores.
     *
     * Three SQL queries (one per audit type) over a 6-year window cover all
     * three granularities; the buckets are computed in-process from a single
     * fetch rather than re-querying per granularity.
     *
     * @param  list<int>  $storeIds
     */
    public function handleForStores(array $storeIds, ?CarbonImmutable $now = null): ViolationsOverviewData
    {
        $now ??= CarbonImmutable::now();

        if ($storeIds === []) {
            return $this->emptyData($now);
        }

        $windowStart = $now->subYears(self::PERIODS - 1)->startOfYear();

        $opens = $this->collectOpens($storeIds, $windowStart, $now);
        $closes = $this->collectCloses($storeIds, $windowStart, $now);

        return new ViolationsOverviewData(
            monthly: $this->bucketize($opens, $closes, $now, 'monthly'),
            quarterly: $this->bucketize($opens, $closes, $now, 'quarterly'),
            yearly: $this->bucketize($opens, $closes, $now, 'yearly'),
        );
    }

    /**
     * @param  'monthly'|'quarterly'|'yearly'  $granularity
     * @return list<array{label:string, opened:int, closed:int}>
     */
    private function emptyBuckets(CarbonImmutable $now, string $granularity): array
    {
        return $this->bucketize([], [], $now, $granularity);
    }

    private function emptyData(CarbonImmutable $now): ViolationsOverviewData
    {
        return new ViolationsOverviewData(
            monthly: $this->emptyBuckets($now, 'monthly'),
            quarterly: $this->emptyBuckets($now, 'quarterly'),
            yearly: $this->emptyBuckets($now, 'yearly'),
        );
    }

    /**
     * Pull every {date, count} pair representing violations "opened" in window.
     * One row per audit; count is the number of violations on that audit.
     *
     * @param  list<int>  $storeIds
     * @return list<array{date:CarbonImmutable, count:int}>
     */
    private function collectOpens(array $storeIds, CarbonImmutable $windowStart, CarbonImmutable $now): array
    {
        $rows = [];

        foreach (self::AUDIT_CLASSES as $auditClass) {
            /** @var Builder<ViolationAudit&Model> $query */
            $query = $auditClass::query();

            $audits = $query
                ->whereIn('store_id', $storeIds)
                ->whereNotNull('completed_date')
                ->whereBetween('completed_date', [$windowStart->toDateString(), $now->toDateString()])
                ->withCount('violations')
                ->get(['id', 'completed_date']);

            foreach ($audits as $audit) {
                $count = (int) ($audit->violations_count ?? 0);
                if ($count === 0) {
                    continue;
                }
                if (! $audit->completed_date instanceof DateTimeInterface) {
                    continue;
                }

                $rows[] = [
                    'date' => CarbonImmutable::instance($audit->completed_date),
                    'count' => $count,
                ];
            }
        }

        return $rows;
    }

    /**
     * Pull every {date, count} pair representing remediations "closed" in window.
     * Each completed remediation contributes 1 to its bucket on completed_date.
     *
     * @param  list<int>  $storeIds
     * @return list<array{date:CarbonImmutable, count:int}>
     */
    private function collectCloses(array $storeIds, CarbonImmutable $windowStart, CarbonImmutable $now): array
    {
        $rows = [];

        foreach (self::AUDIT_CLASSES as $auditClass) {
            /** @var Builder<ViolationAudit&Model> $query */
            $query = $auditClass::query();

            $auditIds = $query
                ->whereIn('store_id', $storeIds)
                ->pluck('id')
                ->all();

            if ($auditIds === []) {
                continue;
            }

            $morphType = (new $auditClass)->getMorphClass();

            $remediations = Remediation::query()
                ->where('completed', true)
                ->whereNotNull('completed_date')
                ->whereBetween('completed_date', [$windowStart->toDateString(), $now->toDateString()])
                ->whereHas('violation', function (Builder $q) use ($morphType, $auditIds): void {
                    $q->where('violationable_type', $morphType)
                        ->whereIn('violationable_id', $auditIds);
                })
                ->get(['id', 'completed_date']);

            foreach ($remediations as $remediation) {
                if (! $remediation->completed_date instanceof DateTimeInterface) {
                    continue;
                }

                $rows[] = [
                    'date' => CarbonImmutable::instance($remediation->completed_date),
                    'count' => 1,
                ];
            }
        }

        return $rows;
    }

    /**
     * @param  list<array{date:CarbonImmutable, count:int}>  $opens
     * @param  list<array{date:CarbonImmutable, count:int}>  $closes
     * @param  'monthly'|'quarterly'|'yearly'  $granularity
     * @return list<array{label:string, opened:int, closed:int}>
     */
    private function bucketize(array $opens, array $closes, CarbonImmutable $now, string $granularity): array
    {
        $periods = $this->periodEdges($now, $granularity);

        $opensByKey = [];
        foreach ($opens as $row) {
            $key = $this->keyFor($row['date'], $granularity);
            $opensByKey[$key] = ($opensByKey[$key] ?? 0) + $row['count'];
        }

        $closesByKey = [];
        foreach ($closes as $row) {
            $key = $this->keyFor($row['date'], $granularity);
            $closesByKey[$key] = ($closesByKey[$key] ?? 0) + $row['count'];
        }

        $result = [];
        foreach ($periods as $period) {
            $result[] = [
                'label' => $period['label'],
                'opened' => (int) ($opensByKey[$period['key']] ?? 0),
                'closed' => (int) ($closesByKey[$period['key']] ?? 0),
            ];
        }

        return $result;
    }

    /**
     * @param  'monthly'|'quarterly'|'yearly'  $granularity
     * @return list<array{key:string, label:string}>
     */
    private function periodEdges(CarbonImmutable $now, string $granularity): array
    {
        $edges = [];

        for ($offset = self::PERIODS - 1; $offset >= 0; $offset--) {
            $point = match ($granularity) {
                'monthly' => $now->subMonths($offset)->startOfMonth(),
                'quarterly' => $now->subQuarters($offset)->startOfQuarter(),
                'yearly' => $now->subYears($offset)->startOfYear(),
            };

            $edges[] = [
                'key' => $this->keyFor($point, $granularity),
                'label' => $this->labelFor($point, $granularity),
            ];
        }

        return $edges;
    }

    /**
     * @param  'monthly'|'quarterly'|'yearly'  $granularity
     */
    private function keyFor(CarbonImmutable $date, string $granularity): string
    {
        return match ($granularity) {
            'monthly' => $date->format('Y-m'),
            'quarterly' => $date->year.'-Q'.$date->quarter,
            'yearly' => (string) $date->year,
        };
    }

    /**
     * @param  'monthly'|'quarterly'|'yearly'  $granularity
     */
    private function labelFor(CarbonImmutable $date, string $granularity): string
    {
        return match ($granularity) {
            'monthly' => $date->format('M'),
            'quarterly' => 'Q'.$date->quarter.' '.($date->year % 100),
            'yearly' => (string) $date->year,
        };
    }
}
