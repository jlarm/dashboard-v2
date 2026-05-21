<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Queries;

use App\Domain\Tenant\User\Data\EmployeeData;
use App\Domain\Tenant\User\Data\EmployeeFiltersData;
use App\Domain\Tenant\User\Data\TrainingCountsData;
use App\Domain\Tenant\User\Data\TrainingSummaryData;
use App\Enums\Role;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\User;
use App\Services\TrainingComplianceService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class GetEmployees
{
    private const array SELECT_COLUMNS = [
        'users.id',
        'users.name',
        'users.slug',
        'users.email',
        'users.department_id',
    ];

    public function __construct(private readonly TrainingComplianceService $complianceService) {}

    /**
     * Invalidate every cached trainingCounts entry for the current tenant.
     */
    public static function bustTrainingCounts(): void
    {
        $tenantId = (string) (tenant('id') ?? 'no-tenant');
        Cache::increment(self::trainingCountsVersionKey($tenantId));
    }

    /**
     * @return LengthAwarePaginator<int, User>
     */
    public function handle(User $viewer, EmployeeFiltersData $filters, int $page = 1): LengthAwarePaginator
    {
        $baseQuery = $this->baseQuery($viewer, $filters);
        $paginatedQuery = (clone $baseQuery)
            ->with(['results' => $this->constrainResultsQuery(...)]);

        if ($filters->hasComplianceFilter()) {
            $matchingIds = $this->idsMatchingComplianceFilter($viewer, $filters);
            $paginatedQuery->whereIn('users.id', $matchingIds);
        }

        $paginator = $paginatedQuery->paginate(perPage: 15, page: $page);

        /** @var Collection<int, User> $pageUsers */
        $pageUsers = collect($paginator->items());
        $pageSummaries = $this->summariesFor($pageUsers);

        $paginator->setCollection(
            $pageUsers->map(fn (User $user): EmployeeData => EmployeeData::fromModel( // @phpstan-ignore argument.type
                user: $user,
                training: $pageSummaries->get($user->id) ?? $this->unassignedSummary(),
                canView: $this->canView($viewer, $user),
            )),
        );

        return $paginator;
    }

    /**
     * Aggregate compliance counts for the entire scoped set.
     *
     * Materializing every user is unavoidable because compliance status depends
     * on per-user roles, department, store states, and course overrides — logic
     * that doesn't translate to a single SQL aggregate. Cached for 5 minutes;
     * invalidated by bumping the tenant-wide version key (see ::bustTrainingCounts).
     */
    public function trainingCounts(User $viewer, EmployeeFiltersData $filters): TrainingCountsData
    {
        return Cache::flexible(
            $this->trainingCountsCacheKey($viewer, $filters),
            [60, 300],
            fn (): TrainingCountsData => $this->computeTrainingCounts($viewer, $filters),
        );
    }

    /**
     * @return Builder<User>
     */
    public function buildScopedQuery(User $viewer, EmployeeFiltersData $filters): Builder
    {
        return $this->baseQuery($viewer, $filters);
    }

    public function isVisibleTo(User $viewer, User $target): bool
    {
        return $this->buildScopedQuery($viewer, EmployeeFiltersData::empty())
            ->where('users.id', $target->id)
            ->exists();
    }

    /**
     * @param  Collection<int, User>  $users
     * @return Collection<int, TrainingSummaryData>
     */
    public function summariesFor(Collection $users): Collection
    {
        return $this->complianceService
            ->summarizeUsers($users->values())
            ->map(static fn (array $summary): TrainingSummaryData => TrainingSummaryData::fromArray($summary));
    }

    private static function trainingCountsVersionKey(string $tenantId): string
    {
        return "employees_training_counts_version:{$tenantId}";
    }

    private function computeTrainingCounts(User $viewer, EmployeeFiltersData $filters): TrainingCountsData
    {
        /** @var Collection<int, User> $scopedUsers */
        $scopedUsers = (clone $this->baseQuery($viewer, $filters))
            ->without(['department'])
            ->get();

        return TrainingCountsData::fromSummaries($this->summariesFor($scopedUsers));
    }

    private function trainingCountsCacheKey(User $viewer, EmployeeFiltersData $filters): string
    {
        return $this->buildCacheKey('employees_training_counts', $viewer, $filters);
    }

    /**
     * @return list<int>
     */
    private function idsMatchingComplianceFilter(User $viewer, EmployeeFiltersData $filters): array
    {
        return Cache::flexible(
            $this->buildCacheKey('employees_compliance_ids', $viewer, $filters),
            [60, 300],
            function () use ($viewer, $filters): array {
                /** @var Collection<int, User> $scopedUsers */
                $scopedUsers = (clone $this->baseQuery($viewer, $filters))->without(['department'])->get();
                $summaries = $this->summariesFor($scopedUsers);

                return $summaries
                    ->filter(fn (TrainingSummaryData $summary): bool => $this->passesComplianceFilter($summary, $filters))
                    ->keys()
                    ->all();
            },
        );
    }

    private function buildCacheKey(string $namespace, User $viewer, EmployeeFiltersData $filters): string
    {
        $tenantId = (string) (tenant('id') ?? 'no-tenant');
        $version = (int) Cache::get(self::trainingCountsVersionKey($tenantId), 0);
        $scopeKey = $viewer->can('create-stores')
            ? 'all'
            : "dept-{$viewer->department_id}";
        $storeKey = app()->bound('scopedStoreIds')
            ? resolve('scopedStoreIds')->map(static fn (mixed $id): int => (int) $id)->sort()->implode('_')
            : '';
        $filtersHash = md5(serialize($filters->toArray()));

        return "{$namespace}:v{$version}:{$tenantId}:{$scopeKey}:{$storeKey}:{$filtersHash}";
    }

    /**
     * @return Builder<User>
     */
    private function baseQuery(User $viewer, EmployeeFiltersData $filters): Builder
    {
        $query = $this->initialQuery($viewer)
            ->whereDoesntHave('roles', function (Builder $query): void {
                $query->whereIn('name', [Role::SuperAdmin->value, Role::Consultant->value]);
            })
            ->select(self::SELECT_COLUMNS)
            ->with([
                'roles:id,name',
                'department:id,name',
                'stores:id,name,state',
                'courseOverrides:user_id,course_id,type',
            ]);

        $this->applyDepartmentFilter($query, $filters);
        $this->applyRoleFilter($query, $filters);
        $this->applySearchFilter($query, $filters);
        $this->applySorting($query, $filters);
        $this->applyStoreFilter($query);

        return $query;
    }

    /**
     * @return Builder<User>
     */
    private function initialQuery(User $viewer): Builder
    {
        $query = User::query();

        if ($viewer->cannot('create-stores') && $viewer->department_id) {
            $query->where('department_id', $viewer->department_id);
        }

        return $query;
    }

    /**
     * @param  Builder<User>  $query
     */
    private function applyDepartmentFilter(Builder $query, EmployeeFiltersData $filters): void
    {
        if ($filters->departmentIds !== []) {
            $query->whereIn('department_id', $filters->departmentIds);
        }
    }

    /**
     * @param  Builder<User>  $query
     */
    private function applyRoleFilter(Builder $query, EmployeeFiltersData $filters): void
    {
        if ($filters->roleIds !== []) {
            $query->whereHas('roles', function (Builder $query) use ($filters): void {
                $query->whereIn('roles.id', $filters->roleIds);
            });
        }
    }

    /**
     * @param  Builder<User>  $query
     */
    private function applySearchFilter(Builder $query, EmployeeFiltersData $filters): void
    {
        if ($filters->search === '') {
            return;
        }

        $query->where(function (Builder $query) use ($filters): void {
            $query->where('name', 'like', "%{$filters->search}%")
                ->orWhere('email', 'like', "%{$filters->search}%");
        });
    }

    /**
     * @param  Builder<User>  $query
     */
    private function applySorting(Builder $query, EmployeeFiltersData $filters): void
    {
        match ($filters->sortField) {
            'department' => $query->orderBy(
                DB::table('departments')
                    ->select('name')
                    ->whereColumn('departments.id', 'users.department_id')
                    ->limit(1),
                $filters->sortDirection,
            ),
            'role' => $query->orderBy(
                DB::table('model_has_roles')
                    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->whereColumn('model_has_roles.model_id', 'users.id')
                    ->where('model_has_roles.model_type', User::class)
                    ->orderBy('roles.name')
                    ->limit(1)
                    ->select('roles.name'),
                $filters->sortDirection,
            ),
            default => $query->orderBy('users.name', $filters->sortDirection),
        };
    }

    /**
     * @param  Builder<User>  $query
     */
    private function applyStoreFilter(Builder $query): void
    {
        if (! app()->bound('multipleStoresExist') || ! resolve('multipleStoresExist')) {
            return;
        }

        /** @var Collection<int, int> $storeIds */
        $storeIds = app()->bound('scopedStoreIds') ? resolve('scopedStoreIds') : collect();

        if ($storeIds->isEmpty()) {
            $query->whereRaw('1 = 0');

            return;
        }

        $query->whereHas('stores', function (Builder $query) use ($storeIds): void {
            $query->whereIn('stores.id', $storeIds);
        });
    }

    /**
     * @param  HasMany<CourseResults, User>  $query
     */
    private function constrainResultsQuery(HasMany $query): void
    {
        $courseIdsByExpiryYears = once(fn (): array => Course::query()
            ->select(['id', 'years_expires'])
            ->get()
            ->groupBy(fn (Course $course): int => (int) ($course->years_expires ?? 1))
            ->map(fn (Collection $courses): array => $courses->pluck('id')->all())
            ->all());

        $query->select('id', 'user_id', 'course_id', 'passed', 'created_at')
            ->where('passed', 1)
            ->where(function (Builder $query) use ($courseIdsByExpiryYears): void {
                $hasCourseWindow = false;

                foreach ($courseIdsByExpiryYears as $yearsExpires => $courseIds) {
                    if ($courseIds === []) {
                        continue;
                    }

                    $windowStartsAt = now()->subYears((int) $yearsExpires);

                    if (! $hasCourseWindow) {
                        $query->where(function (Builder $query) use ($courseIds, $windowStartsAt): void {
                            $query->whereIn('course_id', $courseIds)
                                ->where('created_at', '>=', $windowStartsAt);
                        });
                        $hasCourseWindow = true;

                        continue;
                    }

                    $query->orWhere(function (Builder $query) use ($courseIds, $windowStartsAt): void {
                        $query->whereIn('course_id', $courseIds)
                            ->where('created_at', '>=', $windowStartsAt);
                    });
                }

                if (! $hasCourseWindow) {
                    $query->whereRaw('1 = 0');
                }
            });
    }

    private function passesComplianceFilter(TrainingSummaryData $summary, EmployeeFiltersData $filters): bool
    {
        if ($filters->onlyIncomplete && $summary->notCompleted <= 0) {
            return false;
        }

        if ($filters->onlyExpired && $summary->expired <= 0) {
            return false;
        }

        return ! ($filters->onlyExpiringSoon && $summary->expiringSoon <= 0);
    }

    private function canView(User $viewer, User $target): bool
    {
        if ($viewer->id === $target->id) {
            return false;
        }

        return ! $target->hasRole(Role::Consultant->value);
    }

    private function unassignedSummary(): TrainingSummaryData
    {
        return new TrainingSummaryData(
            totalRequired: 0,
            validCompleted: 0,
            notCompleted: 0,
            expired: 0,
            expiringSoon: 0,
            status: 'unassigned',
        );
    }
}
