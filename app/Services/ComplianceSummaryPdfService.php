<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\File;
use Spatie\Browsershot\Browsershot;

class ComplianceSummaryPdfService
{
    /**
     * Generate a compliance summary PDF for the given stores and return its absolute path.
     * The caller is responsible for deleting the file after use.
     */
    public function generate(Collection $stores, string $reportPeriod): string
    {
        $directory = storage_path('app/compliance-summary');

        if (! File::isDirectory($directory)) {
            File::makeDirectory($directory, 0777, true, true);
        }

        $fileName = implode('-', array_filter([
            tenant('id'),
            now()->format('Ymd-His'),
            'compliance-summary',
        ])).'.pdf';

        $fullPath = $directory.'/'.$fileName;

        $storesData = $stores->map(fn (Store $store): array => $this->collectStoreData($store))->all();

        $html = view('dealer.reports.compliance-summary-pdf', [
            'storesData' => $storesData,
            'overallGroupGrade' => $this->calculateGroupGrade($storesData),
            'reportPeriod' => $reportPeriod,
            'generatedAt' => now(),
            'tenantName' => (string) tenant('name'),
            'isSingleStore' => count($storesData) === 1,
        ])->render();

        Browsershot::html($html)
            ->setNodeBinary($this->resolveNodeBinary())
            ->showBackground()
            ->format('A4')
            ->windowSize(682, 1043)
            ->margins(10.58, 14.82, 10.58, 14.82)
            ->waitUntilNetworkIdle()
            ->save($fullPath);

        return $fullPath;
    }

    /**
     * @return array<string, mixed>
     */
    public function collectStoreData(Store $store): array
    {
        $latestOsha = $store->oshaViolationAudits()
            ->whereNotNull('completed_date')
            ->latest('date')
            ->first();

        $latestBodyShop = $store->bodyShopViolationAudits()
            ->whereNotNull('completed_date')
            ->latest('date')
            ->first();

        $latestGlba = $store->glbaViolationAudits()
            ->whereNotNull('completed_date')
            ->latest('date')
            ->first();

        $openViolations = [
            'osha' => $latestOsha?->outstanding_remediation_count,
            'body_shop' => $latestBodyShop?->outstanding_remediation_count,
            'glba' => $latestGlba?->outstanding_remediation_count,
        ];

        $completedCounts = array_filter($openViolations, static fn (?int $v): bool => $v !== null);
        $totalOpenViolations = $completedCounts === [] ? null : array_sum($completedCounts);

        $trainingStats = $this->calculateTrainingStats($store);

        $vendorQuery = Vendor::query()
            ->where(function ($query) use ($store): void {
                $query->where('store_id', $store->id)
                    ->orWhereNull('store_id');
            });

        $totalVendors = $vendorQuery->count();
        $completedVendors = (clone $vendorQuery)
            ->whereHas('latestForm', fn ($q) => $q->where(fn ($q) => $q->whereNotNull('signature')->orWhereNotNull('document_path')))
            ->count();

        $vendorPercentage = $totalVendors > 0
            ? (int) round(($completedVendors / $totalVendors) * 100)
            : 0;

        $vendorGrade = match (true) {
            $totalVendors === 0 => 'N/A',
            $vendorPercentage >= 90 => 'A',
            $vendorPercentage >= 80 => 'B',
            $vendorPercentage >= 70 => 'C',
            $vendorPercentage >= 60 => 'D',
            default => 'F',
        };

        $grades = [
            'osha' => $store->osha_grade ?? 'N/A',
            'body_shop' => $store->body_shop_grade ?? 'N/A',
            'glba' => $store->glba_grade ?? 'N/A',
            'deal_jacket' => $store->deal_jacket_grade ?? 'N/A',
        ];

        return [
            'store' => $store,
            'overallGrade' => $this->calculateCompositeGrade(
                $grades,
                $trainingStats['percentage'],
                $vendorPercentage,
                $totalOpenViolations ?? 0,
            ),
            'grades' => $grades,
            'openViolations' => $openViolations,
            'totalOpenViolations' => $totalOpenViolations,
            'trainingStats' => $trainingStats,
            'vendorStats' => [
                'total' => $totalVendors,
                'completed' => $completedVendors,
                'percentage' => $vendorPercentage,
                'grade' => $vendorGrade,
            ],
        ];
    }

    /**
     * @return array{total: int, completed: int, percentage: int}
     */
    private function calculateTrainingStats(Store $store): array
    {
        $oneYearAgo = now()->subYear();
        $threeYearsAgo = now()->subYears(3);

        $users = User::query()
            ->whereHas('stores', fn ($q) => $q->where('stores.id', $store->id))
            ->whereHas('roles', fn ($q) => $q->where('id', '!=', 5))
            ->with([
                'roles:id,name',
                'stores:id,state',
                'courseOverrides:user_id,course_id,type',
                'results' => function ($q) use ($oneYearAgo, $threeYearsAgo): void {
                    $q->select('id', 'user_id', 'course_id', 'passed', 'created_at')
                        ->where('passed', 1)
                        ->where(function ($query) use ($oneYearAgo, $threeYearsAgo): void {
                            $query->where('created_at', '>=', $oneYearAgo)
                                ->orWhere(function ($query) use ($threeYearsAgo): void {
                                    $query->whereIn('course_id', [9, 10, 11, 12])
                                        ->where('created_at', '>=', $threeYearsAgo);
                                });
                        })
                        ->whereNull('deleted_at');
                },
            ])
            ->get();

        $totalCount = 0;
        $completedCount = 0;

        foreach ($users as $user) {
            if ($user->total_user_courses === 0) {
                continue;
            }

            $totalCount++;

            if (! $user->user_has_not_completed_courses) {
                $completedCount++;
            }
        }

        return [
            'total' => $totalCount,
            'completed' => $completedCount,
            'percentage' => $totalCount > 0
                ? (int) round(($completedCount / $totalCount) * 100)
                : 0,
        ];
    }

    /**
     * Average composite grade across all stores in the report.
     *
     * @param  array<int, array<string, mixed>>  $storesData
     */
    private function calculateGroupGrade(array $storesData): string
    {
        $gradeValues = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'F' => 0];

        $scores = array_filter(
            array_map(
                fn (array $sd): ?int => $gradeValues[$sd['overallGrade']] ?? null,
                $storesData
            ),
            fn (?int $v): bool => $v !== null
        );

        if ($scores === []) {
            return 'N/A';
        }

        $avg = array_sum($scores) / count($scores);

        return match (true) {
            $avg >= 3.5 => 'A',
            $avg >= 2.5 => 'B',
            $avg >= 1.5 => 'C',
            $avg >= 0.5 => 'D',
            default => 'F',
        };
    }

    private function resolveNodeBinary(): string
    {
        $configured = config('services.browsershot.node_binary');

        if (is_string($configured) && $configured !== '' && File::exists($configured)) {
            return $configured;
        }

        foreach (['/opt/homebrew/bin/node', '/usr/local/bin/node'] as $candidate) {
            if (File::exists($candidate)) {
                return $candidate;
            }
        }

        return 'node';
    }

    /**
     * Composite grade blending audit grades (60%), training completion (25%),
     * and vendor compliance (15%). Open violations cap the maximum achievable grade.
     *
     * @param  array<string, string>  $grades
     */
    private function calculateCompositeGrade(
        array $grades,
        int $trainingPercentage,
        int $vendorPercentage,
        int $totalOpenViolations,
    ): string {
        $gradeValues = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'F' => 0];

        $validAuditGrades = array_values(array_filter(
            $grades,
            fn (string $g): bool => isset($gradeValues[$g])
        ));

        if ($validAuditGrades === []) {
            return 'N/A';
        }

        $auditScore = array_sum(array_map(fn (string $g): int => $gradeValues[$g], $validAuditGrades))
            / count($validAuditGrades);

        $percentageToScore = fn (int $pct): float => match (true) {
            $pct >= 90 => 4.0,
            $pct >= 80 => 3.0,
            $pct >= 70 => 2.0,
            $pct >= 60 => 1.0,
            default => 0.0,
        };

        $composite = ($auditScore * 0.60)
            + ($percentageToScore($trainingPercentage) * 0.25)
            + ($percentageToScore($vendorPercentage) * 0.15);

        $cap = match (true) {
            $totalOpenViolations >= 3 => 2.5,
            $totalOpenViolations >= 1 => 3.5,
            default => 4.0,
        };

        $composite = min($composite, $cap);

        return match (true) {
            $composite >= 3.5 => 'A',
            $composite >= 2.5 => 'B',
            $composite >= 1.5 => 'C',
            $composite >= 0.5 => 'D',
            default => 'F',
        };
    }
}
