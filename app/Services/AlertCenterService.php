<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

readonly class AlertCenterService
{
    public function __construct(private TrainingComplianceService $trainingComplianceService) {}

    public function scopedEmployeeQuery(User $user): Builder
    {
        $generalCourseCutoffDate = now()->subYear();
        $specialCourseCutoffDate = now()->subYears(3);
        $specialCourseIds = [9, 10, 11, 12];

        $query = User::query()
            ->whereDoesntHave('roles', function ($query): void {
                $query->where('name', 'super-admin')
                    ->orWhere('name', 'Consultant');
            })
            ->select(['users.id', 'users.name', 'users.slug', 'users.email', 'users.department_id'])
            ->with([
                'department:id,name',
                'stores:id,name,state',
                'roles:id,name',
                'courseOverrides:user_id,course_id,type',
                'results' => function ($query) use ($generalCourseCutoffDate, $specialCourseCutoffDate, $specialCourseIds): void {
                    $query->select('id', 'user_id', 'course_id', 'passed', 'created_at')
                        ->where('passed', 1)
                        ->where(function ($query) use ($generalCourseCutoffDate, $specialCourseCutoffDate, $specialCourseIds): void {
                            $query->where(function ($query) use ($generalCourseCutoffDate, $specialCourseIds): void {
                                $query->whereNotIn('course_id', $specialCourseIds)
                                    ->where('created_at', '>=', $generalCourseCutoffDate);
                            })->orWhere(function ($query) use ($specialCourseCutoffDate, $specialCourseIds): void {
                                $query->whereIn('course_id', $specialCourseIds)
                                    ->where('created_at', '>=', $specialCourseCutoffDate);
                            });
                        });
                },
            ])
            ->orderBy('users.name');

        $scopedStoreIds = $this->resolveScopedStoreIds();

        if ($scopedStoreIds->isEmpty()) {
            $query->whereRaw('1 = 0');

            return $query;
        }

        $query->whereHas('stores', function ($query) use ($scopedStoreIds): void {
            $query->whereIn('stores.id', $scopedStoreIds);
        });

        if ($user->cannot('create-stores') && $user->department_id !== null) {
            $query->where('department_id', $user->department_id);
        }

        return $query;
    }

    /**
     * @param  Collection<int, mixed>  $users
     * @return Collection<int, array{
     *     total_required: int,
     *     valid_completed: int,
     *     not_completed: int,
     *     expired: int,
     *     expiring_soon: int,
     *     status: 'compliant'|'at_risk'|'overdue'|'unassigned'
     * }>
     */
    public function summarizeUsers(Collection $users): Collection
    {
        return $this->trainingComplianceService->summarizeUsers($this->normalizeUsers($users));
    }

    /**
     * @param  Collection<int, mixed>  $users
     * @param  Collection<int, array{
     *     total_required: int,
     *     valid_completed: int,
     *     not_completed: int,
     *     expired: int,
     *     expiring_soon: int,
     *     status: 'compliant'|'at_risk'|'overdue'|'unassigned'
     * }>  $summaries
     * @return Collection<int, array{
     *     user: User,
     *     status: string,
     *     status_label: string,
     *     total_required: int,
     *     valid_completed: int,
     *     not_completed: int,
     *     expired: int,
     *     expiring_soon: int
     * }>
     */
    public function buildTrainingAlerts(Collection $users, Collection $summaries): Collection
    {
        return $this->normalizeUsers($users)
            ->map(function (User $user) use ($summaries): ?array {
                $summary = $summaries->get($user->id);

                if (! is_array($summary)) {
                    return null;
                }

                if ($summary['expired'] <= 0 && $summary['not_completed'] <= 0 && $summary['expiring_soon'] <= 0) {
                    return null;
                }

                if ($summary['status'] !== 'overdue' && $summary['status'] !== 'at_risk') {
                    return null;
                }

                $status = $summary['status'] === 'overdue' ? 'overdue' : 'at_risk';
                $statusLabel = $status === 'overdue' ? 'Overdue' : 'At Risk';

                return [
                    'user' => $user,
                    'status' => $status,
                    'status_label' => $statusLabel,
                    'total_required' => $summary['total_required'],
                    'valid_completed' => $summary['valid_completed'],
                    'not_completed' => $summary['not_completed'],
                    'expired' => $summary['expired'],
                    'expiring_soon' => $summary['expiring_soon'],
                ];
            })
            ->filter()
            ->values();
    }

    /**
     * @param  Collection<int, array{
     *     total_required: int,
     *     valid_completed: int,
     *     not_completed: int,
     *     expired: int,
     *     expiring_soon: int,
     *     status: 'compliant'|'at_risk'|'overdue'|'unassigned'
     * }>  $summaries
     * @return array{
     *     employees: int,
     *     compliant: int,
     *     at_risk: int,
     *     overdue: int,
     *     unassigned: int,
     *     incomplete_courses: int,
     *     expired_courses: int,
     *     expiring_soon_courses: int
     * }
     */
    public function summarizeCounts(Collection $summaries): array
    {
        return $summaries->reduce(
            function (array $carry, array $summary): array {
                $carry['employees']++;
                $carry[$summary['status']]++;
                $carry['incomplete_courses'] += $summary['not_completed'];
                $carry['expired_courses'] += $summary['expired'];
                $carry['expiring_soon_courses'] += $summary['expiring_soon'];

                return $carry;
            },
            [
                'employees' => 0,
                'compliant' => 0,
                'at_risk' => 0,
                'overdue' => 0,
                'unassigned' => 0,
                'incomplete_courses' => 0,
                'expired_courses' => 0,
                'expiring_soon_courses' => 0,
            ],
        );
    }

    /**
     * @return Collection<int, int>
     */
    private function resolveScopedStoreIds(): Collection
    {
        if (! app()->bound('scopedStoreIds')) {
            return collect();
        }

        /** @var Collection<int, int|string> $scopedStoreIds */
        $scopedStoreIds = app('scopedStoreIds');

        return $scopedStoreIds
            ->map(static fn ($id): int => (int) $id)
            ->filter(static fn (int $id): bool => $id > 0)
            ->unique()
            ->map(static fn (int $id): int => $id)
            ->values();
    }

    /**
     * @param  Collection<int, mixed>  $users
     * @return Collection<int, User>
     */
    private function normalizeUsers(Collection $users): Collection
    {
        return $users
            ->filter(static fn ($user): bool => $user instanceof User)
            ->values();
    }
}
