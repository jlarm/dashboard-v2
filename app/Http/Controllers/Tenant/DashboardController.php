<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Domain\Tenant\Compliance\Queries\CalculateComplianceScore;
use App\Domain\Tenant\Compliance\Queries\CalculateExpiredTraining;
use App\Domain\Tenant\Compliance\Queries\CalculateOverdueRemediations;
use App\Domain\Tenant\Compliance\Queries\GetCriticalVulnerabilities;
use App\Http\Controllers\Controller;
use App\Models\ComplianceScoreSnapshot;
use App\Models\Dealer\Store;
use App\Models\TenantComplianceSnapshot;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class DashboardController extends Controller
{
    public function show(
        Request $request,
        CalculateComplianceScore $calculator,
        CalculateOverdueRemediations $overdueQuery,
        CalculateExpiredTraining $trainingQuery,
        GetCriticalVulnerabilities $vulnerabilitiesQuery,
    ): InertiaResponse {
        $stores = $this->resolveScopedStores();

        $compliance = $stores->isEmpty()
            ? $this->emptyComplianceProps()
            : $this->buildComplianceProps($stores, $calculator);

        $overdueRemediations = $stores->isEmpty()
            ? $this->emptyOverdueProps()
            : $this->buildOverdueProps($stores, $overdueQuery);

        $expiredTraining = $stores->isEmpty()
            ? $this->emptyExpiredTrainingProps()
            : $this->buildExpiredTrainingProps($stores, $trainingQuery);

        $criticalVulnerabilities = $stores->isEmpty()
            ? null
            : $this->buildCriticalVulnerabilitiesProps($stores, $vulnerabilitiesQuery);

        return Inertia::render('tenant/Dashboard', [
            'compliance' => $compliance,
            'overdue_remediations' => $overdueRemediations,
            'expired_training' => $expiredTraining,
            'critical_vulnerabilities' => $criticalVulnerabilities,
        ]);
    }

    /**
     * @return EloquentCollection<int, Store>
     */
    private function resolveScopedStores(): EloquentCollection
    {
        if (! app()->bound('scopedStoreIds')) {
            return new EloquentCollection;
        }

        /** @var Collection<int, mixed> $storeIds */
        $storeIds = resolve('scopedStoreIds');
        $ids = $storeIds->map(static fn ($id): int => (int) $id)->filter()->values();

        if ($ids->isEmpty()) {
            return new EloquentCollection;
        }

        return Store::query()->whereIn('id', $ids)->get();
    }

    /**
     * @return array<string, mixed>
     */
    private function emptyComplianceProps(): array
    {
        return [
            'score' => null,
            'previous_score' => null,
            'delta' => null,
            'pillars' => [],
            'computed_at' => null,
            'caption' => 'No stores in scope.',
        ];
    }

    /**
     * @param  EloquentCollection<int, Store>  $stores
     * @return array<string, mixed>
     */
    private function buildComplianceProps(EloquentCollection $stores, CalculateComplianceScore $calculator): array
    {
        $now = CarbonImmutable::now();

        $scores = $stores->map(static fn (Store $store): array => [
            'store' => $store,
            'score' => $calculator->handle($store, $now),
        ]);

        $current = $this->aggregate($scores);
        $previous = $this->previousScore($stores->pluck('id')->all(), $now);

        $delta = $current === null || $previous === null ? null : round($current - $previous, 1);

        return [
            'score' => $current,
            'previous_score' => $previous,
            'delta' => $delta,
            'pillars' => $this->aggregatedPillars($scores),
            'computed_at' => $now->toIso8601String(),
            'caption' => $this->caption($delta),
        ];
    }

    /**
     * Average overall score across the scoped stores. Each store has already
     * had its weights normalized internally, so an unweighted average is
     * correct for the rollup.
     *
     * @param  Collection<int, array{store: Store, score: \App\Domain\Tenant\Compliance\Data\ComplianceScoreData}>  $scores
     */
    private function aggregate(Collection $scores): ?float
    {
        if ($scores->isEmpty()) {
            return null;
        }

        return round((float) $scores->avg(static fn (array $row): float => $row['score']->score), 1);
    }

    /**
     * @param  Collection<int, array{store: Store, score: \App\Domain\Tenant\Compliance\Data\ComplianceScoreData}>  $scores
     * @return list<array<string, mixed>>
     */
    private function aggregatedPillars(Collection $scores): array
    {
        if ($scores->isEmpty()) {
            return [];
        }

        $byKey = [];
        foreach ($scores as $row) {
            foreach ($row['score']->pillars as $pillar) {
                $byKey[$pillar->key] ??= [
                    'key' => $pillar->key,
                    'label' => $pillar->label,
                    'applicable_count' => 0,
                    'inapplicable_count' => 0,
                    'score_total' => 0.0,
                ];

                if ($pillar->applicable) {
                    $byKey[$pillar->key]['applicable_count']++;
                    $byKey[$pillar->key]['score_total'] += $pillar->score;
                } else {
                    $byKey[$pillar->key]['inapplicable_count']++;
                }
            }
        }

        return array_values(array_map(static function (array $row): array {
            $applicable = $row['applicable_count'] > 0;

            return [
                'key' => $row['key'],
                'label' => $row['label'],
                'applicable' => $applicable,
                'score' => $applicable ? round($row['score_total'] / $row['applicable_count'], 1) : null,
                'applicable_stores' => $row['applicable_count'],
                'inapplicable_stores' => $row['inapplicable_count'],
            ];
        }, $byKey));
    }

    /**
     * @param  list<int>  $storeIds
     */
    private function previousScore(array $storeIds, CarbonImmutable $now): ?float
    {
        if ($storeIds === []) {
            return null;
        }

        $cutoff = $now->subMonth()->toDateString();

        $rows = ComplianceScoreSnapshot::query()
            ->whereIn('store_id', $storeIds)
            ->whereDate('scored_on', '<=', $cutoff)
            ->orderByDesc('scored_on')
            ->get(['store_id', 'scored_on', 'score'])
            ->groupBy('store_id')
            ->map(static fn ($group) => $group->first()->score);

        if ($rows->isEmpty()) {
            return null;
        }

        return round((float) $rows->avg(), 1);
    }

    private function caption(?float $delta): string
    {
        if ($delta === null) {
            return 'No prior period to compare.';
        }

        if ($delta > 0) {
            return 'Up '.abs($delta).' pts vs last month';
        }

        if ($delta < 0) {
            return 'Down '.abs($delta).' pts vs last month';
        }

        return 'Unchanged vs last month';
    }

    /**
     * @return array{count:?int, high_severity_count:?int, previous_count:?int, delta_pct:?float}
     */
    private function emptyOverdueProps(): array
    {
        return [
            'count' => null,
            'high_severity_count' => null,
            'previous_count' => null,
            'delta_pct' => null,
        ];
    }

    /**
     * @param  EloquentCollection<int, Store>  $stores
     * @return array{count:int, high_severity_count:int, previous_count:?int, delta_pct:?float}
     */
    private function buildOverdueProps(EloquentCollection $stores, CalculateOverdueRemediations $overdueQuery): array
    {
        $now = CarbonImmutable::now();

        $count = 0;
        $highSeverityCount = 0;

        foreach ($stores as $store) {
            $result = $overdueQuery->handle($store, $now);
            $count += $result['count'];
            $highSeverityCount += $result['high_severity_count'];
        }

        $previousCount = $this->previousOverdueCount($stores->pluck('id')->all(), $now);
        $deltaPct = $this->deltaPercentage($count, $previousCount);

        return [
            'count' => $count,
            'high_severity_count' => $highSeverityCount,
            'previous_count' => $previousCount,
            'delta_pct' => $deltaPct,
        ];
    }

    /**
     * @param  list<int>  $storeIds
     */
    private function previousOverdueCount(array $storeIds, CarbonImmutable $now): ?int
    {
        if ($storeIds === []) {
            return null;
        }

        $cutoff = $now->subMonth()->toDateString();

        $rows = ComplianceScoreSnapshot::query()
            ->whereIn('store_id', $storeIds)
            ->whereNotNull('overdue_count')
            ->whereDate('scored_on', '<=', $cutoff)
            ->orderByDesc('scored_on')
            ->get(['store_id', 'scored_on', 'overdue_count'])
            ->groupBy('store_id')
            ->map(static fn ($group) => (int) $group->first()->overdue_count);

        if ($rows->isEmpty()) {
            return null;
        }

        return (int) $rows->sum();
    }

    private function deltaPercentage(int $current, ?int $previous): ?float
    {
        if ($previous === null || $previous === 0) {
            return null;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    /**
     * @return array{count:?int, expiring_soon_count:?int, previous_count:?int, delta_pct:?float}
     */
    private function emptyExpiredTrainingProps(): array
    {
        return [
            'count' => null,
            'expiring_soon_count' => null,
            'previous_count' => null,
            'delta_pct' => null,
        ];
    }

    /**
     * Single-store scope reads from per-store snapshots; multi-store scope reads
     * from the tenant-wide deduped snapshot so multi-store users count once.
     *
     * @param  EloquentCollection<int, Store>  $stores
     * @return array{count:int, expiring_soon_count:int, previous_count:?int, delta_pct:?float}
     */
    private function buildExpiredTrainingProps(EloquentCollection $stores, CalculateExpiredTraining $trainingQuery): array
    {
        $now = CarbonImmutable::now();

        if ($stores->count() === 1) {
            /** @var Store $store */
            $store = $stores->first();
            $current = $trainingQuery->handleForStore($store);
            $previousCount = $this->previousStoreTrainingCount($store->id, $now);
        } else {
            $current = $trainingQuery->handleForStores($stores->pluck('id')->all());
            $previousCount = $this->previousTenantTrainingCount($now);
        }

        return [
            'count' => $current['count'],
            'expiring_soon_count' => $current['expiring_soon_count'],
            'previous_count' => $previousCount,
            'delta_pct' => $this->deltaPercentage($current['count'], $previousCount),
        ];
    }

    private function previousStoreTrainingCount(int $storeId, CarbonImmutable $now): ?int
    {
        $cutoff = $now->subMonth()->toDateString();

        $row = ComplianceScoreSnapshot::query()
            ->where('store_id', $storeId)
            ->whereNotNull('expired_training_count')
            ->whereDate('scored_on', '<=', $cutoff)
            ->orderByDesc('scored_on')
            ->first(['expired_training_count']);

        return $row === null ? null : (int) $row->expired_training_count;
    }

    private function previousTenantTrainingCount(CarbonImmutable $now): ?int
    {
        $cutoff = $now->subMonth()->toDateString();

        $row = TenantComplianceSnapshot::query()
            ->whereNotNull('expired_training_count')
            ->whereDate('scored_on', '<=', $cutoff)
            ->orderByDesc('scored_on')
            ->first(['expired_training_count']);

        return $row === null ? null : (int) $row->expired_training_count;
    }

    /**
     * Returns null when none of the scoped stores have a Cyrisma instance —
     * the dashboard hides the card in that case.
     *
     * @param  EloquentCollection<int, Store>  $stores
     * @return array{critical_count:int, days_since_last_scan:?int}|null
     */
    private function buildCriticalVulnerabilitiesProps(EloquentCollection $stores, GetCriticalVulnerabilities $vulnerabilitiesQuery): ?array
    {
        $now = CarbonImmutable::now();

        $data = $stores->count() === 1
            ? $vulnerabilitiesQuery->handleForStore($stores->first(), $now)
            : $vulnerabilitiesQuery->handleForStores($stores, $now);

        return $data?->toArray();
    }
}
