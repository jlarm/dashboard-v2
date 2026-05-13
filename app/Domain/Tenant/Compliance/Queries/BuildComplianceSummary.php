<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Queries;

use App\Domain\Tenant\Course\DotCertificate;
use App\Enums\Role;
use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

/**
 * Collects the data the executive-summary report needs for one or more
 * stores. Returns a plain array shape that the existing Blade view
 * (dealer.reports.compliance-summary-pdf) consumes directly so the report
 * markup does not have to change.
 *
 * Also exposes per-store and group composite grades so the dashboard's
 * Compliance Score KPI can render the same letter grade the PDF prints —
 * a single source of truth for "compliance" across both surfaces.
 */
class BuildComplianceSummary
{
    /**
     * @var array<string, int>
     */
    public const array GRADE_VALUES = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'F' => 0];

    /**
     * Numeric anchor each letter resolves to when surfacing the composite
     * as a 0–100 score (e.g. for the dashboard KPI card). Centred inside
     * each letter's band so the card reads naturally.
     *
     * @var array<string, int>
     */
    public const array LETTER_SCORE_ANCHORS = ['A' => 95, 'B' => 85, 'C' => 75, 'D' => 65, 'F' => 40];

    /**
     * @param  Collection<int, Store>  $stores
     * @return array{
     *     storesData: list<array<string, mixed>>,
     *     overallGroupGrade: string,
     *     reportPeriod: string,
     *     generatedAt: Carbon,
     *     tenantName: string,
     *     isSingleStore: bool,
     * }
     */
    public function handle(Collection $stores, string $reportPeriod): array
    {
        $storesData = $stores
            ->map(fn (Store $store): array => $this->collectStoreData($store))
            ->all();

        return [
            'storesData' => $storesData,
            'overallGroupGrade' => $this->groupGrade($storesData),
            'reportPeriod' => $reportPeriod,
            'generatedAt' => now(),
            'tenantName' => (string) tenant('name'),
            'isSingleStore' => count($storesData) === 1,
        ];
    }

    /**
     * Compute just the group composite grade — the letter the executive
     * summary prints at the top of the report. Used by the dashboard KPI
     * tile so it shows the exact same grade as the PDF, no recalculation.
     *
     * @param  Collection<int, Store>  $stores
     */
    public function gradeForStores(Collection $stores): string
    {
        $storesData = $stores
            ->map(fn (Store $store): array => $this->collectStoreData($store))
            ->all();

        return $this->groupGrade($storesData);
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

        $trainingStats = $this->trainingStats($store);
        $vendorStats = $this->vendorStats($store);

        $grades = [
            'osha' => $store->osha_grade ?? 'N/A',
            'body_shop' => $store->body_shop_grade ?? 'N/A',
            'glba' => $store->glba_grade ?? 'N/A',
            'deal_jacket' => $store->deal_jacket_grade ?? 'N/A',
        ];

        return [
            'store' => $store,
            'overallGrade' => $this->compositeGrade(
                $grades,
                $trainingStats['percentage'],
                $vendorStats['percentage'],
                $totalOpenViolations ?? 0,
            ),
            'grades' => $grades,
            'openViolations' => $openViolations,
            'totalOpenViolations' => $totalOpenViolations,
            'trainingStats' => $trainingStats,
            'vendorStats' => $vendorStats,
        ];
    }

    /**
     * @return array{total: int, completed: int, percentage: int}
     */
    private function trainingStats(Store $store): array
    {
        $oneYearAgo = now()->subYear();
        $threeYearsAgo = now()->subYears(3);

        $users = User::query()
            ->whereHas('stores', fn ($q) => $q->where('stores.id', $store->id))
            ->whereHas('roles', fn ($q) => $q->where('name', '!=', Role::QualifiedIndividual->value))
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
                                    $query->whereIn('course_id', DotCertificate::HAZMAT_COURSE_IDS)
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
     * @return array{total: int, completed: int, percentage: int, grade: string}
     */
    private function vendorStats(Store $store): array
    {
        $vendorQuery = Vendor::query()
            ->where(function ($query) use ($store): void {
                $query->where('store_id', $store->id)
                    ->orWhereNull('store_id');
            });

        $total = $vendorQuery->count();
        $completed = (clone $vendorQuery)
            ->whereHas('latestForm', fn ($q) => $q->where(fn ($q) => $q->whereNotNull('signature')->orWhereNotNull('document_path')))
            ->count();

        $percentage = $total > 0
            ? (int) round(($completed / $total) * 100)
            : 0;

        $grade = match (true) {
            $total === 0 => 'N/A',
            $percentage >= 90 => 'A',
            $percentage >= 80 => 'B',
            $percentage >= 70 => 'C',
            $percentage >= 60 => 'D',
            default => 'F',
        };

        return [
            'total' => $total,
            'completed' => $completed,
            'percentage' => $percentage,
            'grade' => $grade,
        ];
    }

    /**
     * Composite grade blending audit grades (60%), training completion (25%),
     * and vendor compliance (15%). Open violations cap the maximum achievable
     * grade so a store with many open items can't earn an A on rounding alone.
     *
     * @param  array<string, string>  $grades
     */
    private function compositeGrade(
        array $grades,
        int $trainingPercentage,
        int $vendorPercentage,
        int $totalOpenViolations,
    ): string {
        $validAuditGrades = array_values(array_filter(
            $grades,
            fn (string $g): bool => isset(self::GRADE_VALUES[$g])
        ));

        if ($validAuditGrades === []) {
            return 'N/A';
        }

        $auditScore = array_sum(array_map(fn (string $g): int => self::GRADE_VALUES[$g], $validAuditGrades))
            / count($validAuditGrades);

        $percentageToScore = static fn (int $pct): float => match (true) {
            $pct >= 90 => 4.0,
            $pct >= 80 => 3.0,
            $pct >= 70 => 2.0,
            $pct >= 60 => 1.0,
            default => 0.0,
        };

        $composite = ($auditScore * 0.60)
            + ($percentageToScore($trainingPercentage) * 0.25)
            + ($percentageToScore($vendorPercentage) * 0.15);

        $letter = $this->scoreToLetter($composite);

        // Open-remediation ceiling: 1–2 opens caps the grade at B, 3+ caps
        // at C. Expressed as a letter floor on the grade ladder rather than
        // a numeric ceiling so we don't have to fight the >= thresholds in
        // scoreToLetter (a cap of 3.5 used to still produce an A).
        $letterCap = match (true) {
            $totalOpenViolations >= 3 => 'C',
            $totalOpenViolations >= 1 => 'B',
            default => 'A',
        };

        return self::GRADE_VALUES[$letter] > self::GRADE_VALUES[$letterCap]
            ? $letterCap
            : $letter;
    }

    /**
     * @param  list<array<string, mixed>>  $storesData
     */
    private function groupGrade(array $storesData): string
    {
        $scores = array_filter(
            array_map(
                fn (array $sd): ?int => self::GRADE_VALUES[$sd['overallGrade']] ?? null,
                $storesData
            ),
            static fn (?int $v): bool => $v !== null
        );

        if ($scores === []) {
            return 'N/A';
        }

        return $this->scoreToLetter(array_sum($scores) / count($scores));
    }

    private function scoreToLetter(float $score): string
    {
        return match (true) {
            $score >= 3.5 => 'A',
            $score >= 2.5 => 'B',
            $score >= 1.5 => 'C',
            $score >= 0.5 => 'D',
            default => 'F',
        };
    }
}
