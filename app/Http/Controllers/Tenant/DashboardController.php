<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Domain\Tenant\Compliance\Data\AuditTrackerRowData;
use App\Domain\Tenant\Compliance\Data\ComplianceScoreData;
use App\Domain\Tenant\Compliance\Data\LocationGradeRowData;
use App\Domain\Tenant\Compliance\Data\TrainingCompletionRowData;
use App\Domain\Tenant\Compliance\Queries\CalculateComplianceScore;
use App\Domain\Tenant\Compliance\Queries\CalculateExpiredTraining;
use App\Domain\Tenant\Compliance\Queries\CalculateOverdueRemediations;
use App\Domain\Tenant\Compliance\Queries\CalculateViolationsOverview;
use App\Domain\Tenant\Compliance\Queries\GetAuditTracker;
use App\Domain\Tenant\Compliance\Queries\GetCriticalVulnerabilities;
use App\Domain\Tenant\Compliance\Queries\GetLocationGrades;
use App\Domain\Tenant\Compliance\Queries\GetManualsSummary;
use App\Domain\Tenant\Compliance\Queries\GetTrainingCompletionByDepartment;
use App\Domain\Tenant\Compliance\Queries\GetTrainingComplianceSnapshot;
use App\Domain\Tenant\Course\Queries\CanIssueDotCertificate;
use App\Domain\Tenant\Course\Queries\GetUserCourseList;
use App\Domain\Tenant\Store\Actions\UpdateConsultantNote;
use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Dashboard\UpdateConsultantNoteRequest;
use App\Jobs\Audit\GenerateDealJacketReportJob;
use App\Models\ComplianceScoreSnapshot;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use App\Models\TenantComplianceSnapshot;
use App\Models\User;
use App\Services\ComplianceSummaryPdfService;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends Controller
{
    private const array DOWNLOAD_AUTHORIZED_ROLES = ['super-admin', 'Owner', 'GM', 'CFO', 'GSM', 'Qualified Individual'];

    private const array DOWNLOAD_UNRESTRICTED_ROLES = ['super-admin', 'Consultant'];

    private const array COURSE_DASHBOARD_ROLES = ['Employee', 'Porter/Driver'];

    private const array KPI_RESTRICTED_ROLES = ['Manager', 'Employee', 'Porter/Driver'];

    public function show(
        Request $request,
        CalculateComplianceScore $calculator,
        CalculateOverdueRemediations $overdueQuery,
        CalculateExpiredTraining $trainingQuery,
        GetCriticalVulnerabilities $vulnerabilitiesQuery,
        CalculateViolationsOverview $violationsOverviewQuery,
        GetAuditTracker $auditTrackerQuery,
        GetLocationGrades $locationGradesQuery,
        GetManualsSummary $manualsSummaryQuery,
        GetTrainingComplianceSnapshot $trainingComplianceSnapshotQuery,
        GetTrainingCompletionByDepartment $trainingCompletionQuery,
        GetUserCourseList $courseList,
        CanIssueDotCertificate $canIssueDotCert,
    ): InertiaResponse {
        $user = $request->user();

        if ($user instanceof User && $this->shouldSeeCourseDashboard($user)) {
            return Inertia::render('tenant/EmployeeDashboard', [
                'courses' => $courseList->handle($user)
                    ->map(static fn ($item): array => $item->toArray())
                    ->all(),
                'can_issue_dot_certificate' => $canIssueDotCert->handle($user),
            ]);
        }

        $stores = $this->resolveScopedStores();

        $compliance = $stores->isEmpty()
            ? $this->emptyComplianceProps()
            : $this->buildComplianceProps($stores, $calculator);

        $overdueRemediations = $stores->isEmpty()
            ? null
            : $this->buildOverdueProps($stores, $overdueQuery);

        $expiredTraining = $stores->isEmpty()
            ? $this->emptyExpiredTrainingProps()
            : $this->buildExpiredTrainingProps($stores, $trainingQuery);

        $criticalVulnerabilities = $stores->isEmpty()
            ? null
            : $this->buildCriticalVulnerabilitiesProps($stores, $vulnerabilitiesQuery);

        $violationsOverview = $violationsOverviewQuery
            ->handleForStores($stores->pluck('id')->all())
            ->toArray();

        $auditTrackerRows = collect($auditTrackerQuery->handleForStores($stores->pluck('id')->all()))
            ->filter(static fn (AuditTrackerRowData $row): bool => $row->last_audit_date !== null)
            ->values();

        $auditTracker = $auditTrackerRows->isEmpty()
            ? null
            : $auditTrackerRows->map(static fn (AuditTrackerRowData $row): array => $row->toArray())->all();

        $trainingCompletion = $stores->isEmpty()
            ? []
            : array_map(
                static fn (TrainingCompletionRowData $row): array => $row->toArray(),
                $trainingCompletionQuery->handleForStores($stores->pluck('id')->all()),
            );

        $locationGrades = $stores->count() > 1
            ? array_map(
                static fn (LocationGradeRowData $row): array => $row->toArray(),
                $locationGradesQuery->handleForStores($stores->pluck('id')->all()),
            )
            : null;

        $trainingComplianceSnapshot = $trainingComplianceSnapshotQuery
            ->handleForStores($stores->pluck('id')->all())
            ->toArray();

        $selectedStore = $this->resolveSelectedStore($user, $stores);

        $consultantNote = $selectedStore !== null
            && $user instanceof User
            && $user->hasAnyRole([Role::SuperAdmin->value, Role::Consultant->value])
            ? ['note' => $selectedStore->note]
            : null;

        $manualsSummary = $selectedStore !== null
            && $user instanceof User
            && ! $user->hasAnyRole([Role::SuperAdmin->value, Role::Consultant->value])
            ? $manualsSummaryQuery->handleForStore($selectedStore)->toArray()
            : null;

        $showKpiCards = ! $user instanceof User || ! $this->isRestrictedFromKpis($user);

        return Inertia::render('tenant/Dashboard', [
            'compliance' => $compliance,
            'overdue_remediations' => $overdueRemediations,
            'expired_training' => $expiredTraining,
            'critical_vulnerabilities' => $criticalVulnerabilities,
            'violations_overview' => $violationsOverview,
            'audit_tracker' => $auditTracker,
            'training_completion' => $trainingCompletion,
            'location_grades' => $locationGrades,
            'training_compliance_snapshot' => $trainingComplianceSnapshot,
            'consultant_note' => $consultantNote,
            'manuals_summary' => $manualsSummary,
            'show_kpi_cards' => $showKpiCards,
        ]);
    }

    public function updateConsultantNote(
        UpdateConsultantNoteRequest $request,
        UpdateConsultantNote $updateConsultantNote,
    ): RedirectResponse {
        $user = $request->user();

        $store = $user instanceof User
            ? $this->resolveSelectedStore($user, $this->resolveScopedStores())
            : null;

        abort_if($store === null, 404);

        $updateConsultantNote->handle($store, $request->note());

        return back();
    }

    /**
     * Stream the executive-summary PDF for the user's scoped stores. Mirrors
     * the legacy Livewire ExecutiveSummary::download flow so the dashboard
     * can keep producing the same artefact tenants are used to.
     */
    public function downloadAuditReport(ComplianceSummaryPdfService $pdfService): BinaryFileResponse
    {
        $user = auth()->user();

        abort_unless($user?->hasAnyRole(self::DOWNLOAD_AUTHORIZED_ROLES), 403);

        $stores = $this->resolveScopedStores();

        abort_if($stores->isEmpty(), 404);

        if (! $user->hasAnyRole(self::DOWNLOAD_UNRESTRICTED_ROLES)) {
            $userStoreIds = $user->stores()->pluck('stores.id')->all();
            abort_if($stores->pluck('id')->diff($userStoreIds)->isNotEmpty(), 403);
        }

        $pdfPath = $pdfService->generate($stores, CarbonImmutable::now()->format('F Y'));

        $fileName = implode('-', [
            CarbonImmutable::now()->format('Ymd'),
            $stores->count() === 1
                ? str($stores->first()->name)->slug()->toString()
                : 'overview',
            'audit-report.pdf',
        ]);

        return response()
            ->download($pdfPath, $fileName, ['Content-Type' => 'application/pdf'])
            ->deleteFileAfterSend(true);
    }

    /**
     * Stream the latest completed report for a single audit type, scoped to
     * the user's stores. Mirrors the legacy Livewire per-audit download
     * (AbstractAuditStats::downloadPdf and DealJacketStats::download).
     */
    public function downloadAuditTypeReport(string $type): StreamedResponse
    {
        $stores = $this->resolveScopedStores();

        abort_if($stores->isEmpty(), 404);

        $storeIds = $stores->pluck('id')->all();

        return match ($type) {
            'osha' => $this->streamViolationAuditPdf(OshaViolationAudit::class, $storeIds),
            'body_shop' => $this->streamViolationAuditPdf(BodyShopViolationAudit::class, $storeIds),
            'glba' => $this->streamViolationAuditPdf(GlbaViolationAudit::class, $storeIds),
            'deal_jacket' => $this->streamDealJacketReport($storeIds),
            default => abort(404),
        };
    }

    /**
     * @param  class-string<Model>  $auditClass
     * @param  list<int>  $storeIds
     */
    private function streamViolationAuditPdf(string $auditClass, array $storeIds): StreamedResponse
    {
        $latest = $auditClass::query()
            ->whereIn('store_id', $storeIds)
            ->whereNotNull('grade')
            ->where('grade', '!=', 'N/A')
            ->whereNotNull('pdf_path')
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->first(['pdf_path']);

        abort_if($latest === null || empty($latest->pdf_path), 404, 'No report available.');

        return Storage::disk('armpaudits')->download($latest->pdf_path);
    }

    /**
     * @param  list<int>  $storeIds
     */
    private function streamDealJacketReport(array $storeIds): StreamedResponse
    {
        $group = DealJacketGroup::query()
            ->whereIn('store_id', $storeIds)
            ->where('completed', true)
            ->latest('id')
            ->first();

        abort_if($group === null, 404, 'No completed deal jacket report.');

        $user = auth()->user();
        abort_unless($user instanceof User, 403);

        dispatch_sync(new GenerateDealJacketReportJob($group, $user));

        $storeName = str_replace(' ', '-', (string) $group->store->name);
        $fileName = $group->created_at->format('Ymd-His')."-{$storeName}-deal-jacket-report.pdf";
        $filePath = "deal-jacket-reports/{$fileName}";

        abort_unless(Storage::exists($filePath), 404, 'Report not found or has expired.');

        return Storage::download($filePath, $fileName, ['Content-Type' => 'application/pdf']);
    }

    /**
     * Users whose only roles are Employee or Porter/Driver get the
     * courses-focused dashboard instead of the compliance stats view.
     * If they also carry a higher-tier role, the stats view wins.
     */
    private function shouldSeeCourseDashboard(User $user): bool
    {
        $roleNames = $user->roles->pluck('name')->all();

        if ($roleNames === []) {
            return false;
        }

        return array_diff($roleNames, self::COURSE_DASHBOARD_ROLES) === [];
    }

    /**
     * Managers and lower-tier roles (Employee, Porter/Driver) don't see
     * the executive KPI tiles. A user with any role outside that set —
     * for example a Manager who is also an Owner — still sees them.
     */
    private function isRestrictedFromKpis(User $user): bool
    {
        $roleNames = $user->roles->pluck('name')->all();

        if ($roleNames === []) {
            return true;
        }

        return array_diff($roleNames, self::KPI_RESTRICTED_ROLES) === [];
    }

    /**
     * Returns the single store the user is currently viewing, if any.
     * Falls back to null when the user is in overview mode or the
     * current_store_id is no longer in their scoped store set.
     *
     * @param  EloquentCollection<int, Store>  $stores
     */
    private function resolveSelectedStore(?User $user, EloquentCollection $stores): ?Store
    {
        if (! $user instanceof User || $user->current_store_id === null) {
            return null;
        }

        /** @var Store|null $match */
        $match = $stores->firstWhere('id', (int) $user->current_store_id);

        return $match;
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
     * @param  Collection<int, array{store: Store, score: ComplianceScoreData}>  $scores
     */
    private function aggregate(Collection $scores): ?float
    {
        if ($scores->isEmpty()) {
            return null;
        }

        return round((float) $scores->avg(static fn (array $row): float => $row['score']->score), 1);
    }

    /**
     * @param  Collection<int, array{store: Store, score: ComplianceScoreData}>  $scores
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
            ->latest('scored_on')
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
     * Returns null when none of the scoped stores have an active
     * RemediationSetting — the dashboard then hides the card.
     *
     * @param  EloquentCollection<int, Store>  $stores
     * @return array{count:int, high_severity_count:int, previous_count:?int, delta_pct:?float}|null
     */
    private function buildOverdueProps(EloquentCollection $stores, CalculateOverdueRemediations $overdueQuery): ?array
    {
        $eligible = $stores->filter(static function (Store $store): bool {
            $store->loadMissing('remediationSettings');

            return $store->remediationSettings !== null && $store->remediationSettings->active;
        });

        if ($eligible->isEmpty()) {
            return null;
        }

        $now = CarbonImmutable::now();

        $count = 0;
        $highSeverityCount = 0;

        foreach ($eligible as $store) {
            $result = $overdueQuery->handle($store, $now);
            $count += $result['count'];
            $highSeverityCount += $result['high_severity_count'];
        }

        $previousCount = $this->previousOverdueCount($eligible->pluck('id')->all(), $now);
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
            ->latest('scored_on')
            ->get(['store_id', 'scored_on', 'overdue_count'])
            ->groupBy('store_id')
            ->map(static fn ($group): int => (int) $group->first()->overdue_count);

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
            ->latest('scored_on')
            ->first(['expired_training_count']);

        return $row === null ? null : (int) $row->expired_training_count;
    }

    private function previousTenantTrainingCount(CarbonImmutable $now): ?int
    {
        $cutoff = $now->subMonth()->toDateString();

        $row = TenantComplianceSnapshot::query()
            ->whereNotNull('expired_training_count')
            ->whereDate('scored_on', '<=', $cutoff)
            ->latest('scored_on')
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
