<?php

declare(strict_types=1);

namespace App\Domain\Tenant\DealJackets\Queries;

use App\Models\Dealer\Audit\DealJacketGroup;

class BuildDealJacketCharts
{
    /**
     * @return array{
     *   pass_rate: array{labels: array<int, string>, data: array<int, float>},
     *   common_issues: array{labels: array<int, string>, data: array<int, int>},
     * }
     */
    public function handle(int $storeId): array
    {
        return [
            'pass_rate' => $this->buildPassRateTrend($storeId),
            'common_issues' => $this->buildCommonIssues($storeId),
        ];
    }

    /**
     * @return array{labels: array<int, string>, data: array<int, float>}
     */
    private function buildPassRateTrend(int $storeId): array
    {
        $groups = DealJacketGroup::query()
            ->where('store_id', $storeId)
            ->where('completed', true)
            ->withSum('dealJackets as total_passed', 'total_passed')
            ->withSum('dealJackets as total_failed', 'total_failed')
            ->latest()
            ->limit(8)
            ->get()
            ->reverse();

        $labels = $groups
            ->map(static fn (DealJacketGroup $g): string => $g->created_at?->format("M 'y") ?? '')
            ->values()
            ->all();

        $data = $groups
            ->map(static fn (DealJacketGroup $g): float => (float) ($g->pass_rate ?? 0))
            ->values()
            ->all();

        return ['labels' => $labels, 'data' => $data];
    }

    /**
     * @return array{labels: array<int, string>, data: array<int, int>}
     */
    private function buildCommonIssues(int $storeId): array
    {
        $responses = DealJacketGroup::query()
            ->where('store_id', $storeId)
            ->where('completed', true)
            ->latest()
            ->limit(4)
            ->with('dealJackets')
            ->get()
            ->flatMap(static fn (DealJacketGroup $group) => $group->dealJackets)
            ->pluck('responses')
            ->filter();

        $counts = [];
        foreach ($responses as $responseArray) {
            foreach ($responseArray as $row) {
                if (($row['answer'] ?? null) === 'no' && isset($row['statement'])) {
                    $counts[$row['statement']] = ($counts[$row['statement']] ?? 0) + 1;
                }
            }
        }

        arsort($counts);
        $top = array_slice($counts, 0, 5, true);

        $labels = array_map(
            fn (int|string $label): string => $this->truncate((string) $label),
            array_keys($top),
        );

        return [
            'labels' => $labels,
            'data' => array_values(array_map(static fn ($v): int => (int) $v, $top)),
        ];
    }

    private function truncate(string $label, int $max = 40): string
    {
        return mb_strlen($label) <= $max ? $label : mb_substr($label, 0, $max).'...';
    }
}
