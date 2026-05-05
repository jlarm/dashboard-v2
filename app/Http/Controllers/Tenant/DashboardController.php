<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Domain\Tenant\Compliance\Queries\CalculateComplianceScore;
use App\Http\Controllers\Controller;
use App\Models\ComplianceScoreSnapshot;
use App\Models\Dealer\Store;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class DashboardController extends Controller
{
    public function show(Request $request, CalculateComplianceScore $calculator): InertiaResponse
    {
        $stores = $this->resolveScopedStores();

        $compliance = $stores->isEmpty()
            ? $this->emptyComplianceProps()
            : $this->buildComplianceProps($stores, $calculator);

        return Inertia::render('tenant/Dashboard', [
            'compliance' => $compliance,
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
}
