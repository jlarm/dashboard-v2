<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Queries;

use App\Domain\Tenant\User\Data\EmployeeData;
use App\Domain\Tenant\User\Data\EmployeeFiltersData;
use App\Domain\Tenant\User\Data\TrainingSummaryData;
use App\Models\Dealer\Course;
use App\Models\User;
use App\Services\TrainingComplianceService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GetEmployees
{
    private const SELECT_COLUMNS = [
        'users.id',
        'users.name',
        'users.slug',
        'users.email',
        'users.department_id',
    ];

    public function __construct(private readonly TrainingComplianceService $complianceService) {}

    /**
     * @return array{
     *     paginator: LengthAwarePaginator,
     *     summaries: Collection<int, TrainingSummaryData>
     * }
     */
    public function handle(User $viewer, EmployeeFiltersData $filters, int $page = 1): array
    {
        $baseQuery = $this->baseQuery($viewer, $filters);
        $scopedUsers = (clone $baseQuery)->without(['department'])->get();
        $allSummaries = $this->summariesFor($scopedUsers);

        $perPage = $filters->hasComplianceFilter() ? 500 : 15;

        $paginatedQuery = (clone $baseQuery)
            ->with(['results' => $this->constrainResultsQuery(...)]);

        $paginator = $paginatedQuery->paginate(perPage: $perPage, page: $page);

        /** @var Collection<int, User> $pageUsers */
        $pageUsers = collect($paginator->items());
        $pageSummaries = $allSummaries->only($pageUsers->pluck('id')->all());

        $employees = $filters->hasComplianceFilter()
            ? $pageUsers
                ->filter(fn (User $user): bool => $this->passesComplianceFilter(
                    $pageSummaries->get($user->id),
                    $filters,
                ))
                ->values()
            : $pageUsers->values();

        $paginator->setCollection(
            $employees->map(fn (User $user): EmployeeData => EmployeeData::fromModel(
                user: $user,
                training: $pageSummaries->get($user->id) ?? $this->unassignedSummary(),
                canView: $this->canView($viewer, $user),
            )),
        );

        return [
            'paginator' => $paginator,
            'summaries' => $allSummaries,
        ];
    }

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
            ->summarizeUsers($users->filter(static fn ($user): bool => $user instanceof User)->values())
            ->map(static fn (array $summary): TrainingSummaryData => TrainingSummaryData::fromArray($summary));
    }

    private function baseQuery(User $viewer, EmployeeFiltersData $filters): Builder
    {
        $query = $this->initialQuery($viewer)
            ->whereDoesntHave('roles', function (Builder $query): void {
                $query->where('name', 'super-admin')->orWhere('name', 'Consultant');
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

    private function initialQuery(User $viewer): Builder
    {
        $query = User::query();

        if ($viewer->cannot('create-stores') && $viewer->department_id) {
            $query->where('department_id', $viewer->department_id);
        }

        return $query;
    }

    private function applyDepartmentFilter(Builder $query, EmployeeFiltersData $filters): void
    {
        if ($filters->departmentIds !== []) {
            $query->whereIn('department_id', $filters->departmentIds);
        }
    }

    private function applyRoleFilter(Builder $query, EmployeeFiltersData $filters): void
    {
        if ($filters->roleIds !== []) {
            $query->whereHas('roles', function (Builder $query) use ($filters): void {
                $query->whereIn('roles.id', $filters->roleIds);
            });
        }
    }

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

    private function constrainResultsQuery(HasMany $query): void
    {
        $courseIdsByExpiryYears = Course::query()
            ->select(['id', 'years_expires'])
            ->get()
            ->groupBy(fn (Course $course): int => (int) ($course->years_expires ?? 1))
            ->map(fn (Collection $courses): array => $courses->pluck('id')->all())
            ->all();

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

    private function passesComplianceFilter(?TrainingSummaryData $summary, EmployeeFiltersData $filters): bool
    {
        if (! $summary instanceof TrainingSummaryData) {
            return ! $filters->hasComplianceFilter();
        }

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

        return ! $target->hasRole('Consultant');
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
