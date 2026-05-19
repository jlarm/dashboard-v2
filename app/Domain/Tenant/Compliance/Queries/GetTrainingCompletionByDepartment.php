<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Queries;

use App\Domain\Tenant\Compliance\Data\TrainingCompletionRowData;
use App\Enums\Role;
use App\Models\Dealer\Department;
use App\Models\User;
use App\Services\TrainingComplianceService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class GetTrainingCompletionByDepartment
{
    public function __construct(
        private readonly TrainingComplianceService $service,
    ) {}

    /**
     * Percentage of eligible employees who have completed every assigned
     * course, bucketed by department. Includes a leading "All" row spanning
     * the entire scoped employee set.
     *
     * @param  Collection<int, int>|array<int, int>  $storeIds
     * @return list<TrainingCompletionRowData>
     */
    public function handleForStores(Collection|array $storeIds): array
    {
        $ids = collect($storeIds)
            ->map(static fn (int $id): int => $id)
            ->filter()
            ->values()
            ->all();

        if ($ids === []) {
            return [];
        }

        $users = User::query()
            ->whereDoesntHave('roles', function (Builder $query): void {
                $query->whereIn('name', [Role::SuperAdmin->value, Role::Consultant->value]);
            })
            ->whereHas('stores', function (Builder $query) use ($ids): void {
                $query->whereIn('stores.id', $ids);
            })
            ->with([
                'roles:id,name',
                'courseOverrides:user_id,course_id,type',
                'department:id,name',
            ])
            ->get();

        if ($users->isEmpty()) {
            return [];
        }

        $summaries = $this->service->summarizeUsers($users);

        $allRow = $this->buildRow('All', $users, $summaries);

        $departmentRows = $users
            ->groupBy(function (User $user): string {
                $department = $user->department;

                return $department instanceof Department ? $department->name : 'Unassigned';
            })
            ->sortKeys()
            ->map(fn (Collection $group, string $name): TrainingCompletionRowData => $this->buildRow($name, $group, $summaries))
            ->values()
            ->all();

        return [$allRow, ...$departmentRows];
    }

    /**
     * @param  Collection<int, User>  $users
     * @param  Collection<int, array{total_required:int, valid_completed:int, not_completed:int, expired:int, expiring_soon:int, status:'compliant'|'at_risk'|'overdue'|'unassigned'}>  $summaries
     */
    private function buildRow(string $label, Collection $users, Collection $summaries): TrainingCompletionRowData
    {
        $headcount = $users->count();

        if ($headcount === 0) {
            return new TrainingCompletionRowData($label, 0, 0);
        }

        $currentCount = $users->filter(function (User $user) use ($summaries): bool {
            $summary = $summaries->get($user->id);

            if ($summary === null) {
                return false;
            }

            return $summary['expired'] === 0 && $summary['not_completed'] === 0;
        })->count();

        $value = (int) round(($currentCount / $headcount) * 100);

        return new TrainingCompletionRowData($label, $value, $headcount);
    }
}
