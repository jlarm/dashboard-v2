<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

/**
 * @phpstan-type TrainingComplianceStatus 'compliant'|'at_risk'|'overdue'|'unassigned'
 */
class TrainingComplianceService
{
    public function __construct(private readonly UserCourseService $userCourseService) {}

    /**
     * @param  Collection<int, User>  $users
     * @return Collection<int, array{
     *     total_required: int,
     *     valid_completed: int,
     *     not_completed: int,
     *     expired: int,
     *     expiring_soon: int,
     *     status: 'compliant'|'at_risk'|'overdue'|'unassigned'
     * }>
     *
     * @phpstan-return Collection<int, array{
     *     total_required: int,
     *     valid_completed: int,
     *     not_completed: int,
     *     expired: int,
     *     expiring_soon: int,
     *     status: TrainingComplianceStatus
     * }>
     */
    public function summarizeUsers(Collection $users): Collection
    {
        $normalizedUsers = $users
            ->filter(static fn ($user): bool => $user instanceof User)
            ->values();

        if ($normalizedUsers->isEmpty()) {
            return collect();
        }

        $assignedCourseIdsByUser = [];
        $allCourseIds = collect();

        foreach ($normalizedUsers as $user) {
            $courseIds = collect($this->userCourseService->getCourseIds($user))
                ->map(static fn ($id): int => (int) $id)
                ->filter()
                ->unique()
                ->values();

            $assignedCourseIdsByUser[$user->id] = $courseIds;
            $allCourseIds = $allCourseIds->merge($courseIds);
        }

        $allCourseIds = $allCourseIds->unique()->values();
        $coursesById = Course::query()
            ->whereIn('id', $allCourseIds)
            ->get(['id', 'years_expires'])
            ->keyBy('id');

        $latestPassedResultsByUserAndCourse = $this->latestPassedResultsByUserAndCourse(
            $normalizedUsers->pluck('id')->map(static fn ($id): int => (int) $id)->values(),
            $allCourseIds
        );

        $now = now();
        $expiringSoonCutoff = $now->copy()->addDays(30);

        /** @var Collection<int, array{total_required: int, valid_completed: int, not_completed: int, expired: int, expiring_soon: int, status: TrainingComplianceStatus}> $summaries */
        $summaries = $normalizedUsers->mapWithKeys(function (User $user) use ($assignedCourseIdsByUser, $coursesById, $latestPassedResultsByUserAndCourse, $now, $expiringSoonCutoff): array {
            /** @var Collection<int, int> $assignedCourseIds */
            $assignedCourseIds = $assignedCourseIdsByUser[$user->id] ?? collect();
            $totalRequired = $assignedCourseIds->count();

            if ($totalRequired === 0) {
                return [
                    $user->id => [
                        'total_required' => 0,
                        'valid_completed' => 0,
                        'not_completed' => 0,
                        'expired' => 0,
                        'expiring_soon' => 0,
                        'status' => 'unassigned',
                    ],
                ];
            }

            $validCompleted = 0;
            $expired = 0;
            $expiringSoon = 0;

            foreach ($assignedCourseIds as $courseId) {
                $passedAt = $latestPassedResultsByUserAndCourse[$user->id][$courseId] ?? null;

                if (! $passedAt instanceof CarbonInterface) {
                    continue;
                }

                $yearsExpires = (int) ($coursesById->get($courseId)?->years_expires ?? 1);
                $yearsExpires = $yearsExpires > 0 ? $yearsExpires : 1;

                $expiresAt = $passedAt->copy()->addYears($yearsExpires)->endOfDay();

                if ($expiresAt->lt($now)) {
                    $expired++;

                    continue;
                }

                $validCompleted++;

                if ($expiresAt->lte($expiringSoonCutoff)) {
                    $expiringSoon++;
                }
            }

            $notCompleted = max(0, $totalRequired - $validCompleted);
            /** @var 'compliant'|'at_risk'|'overdue'|'unassigned' $status */
            $status = $this->resolveStatus($totalRequired, $notCompleted, $expired, $expiringSoon);

            return [
                $user->id => [
                    'total_required' => $totalRequired,
                    'valid_completed' => $validCompleted,
                    'not_completed' => $notCompleted,
                    'expired' => $expired,
                    'expiring_soon' => $expiringSoon,
                    'status' => $status,
                ],
            ];
        });

        return $summaries;
    }

    /**
     * @return array{
     *     total_required: int,
     *     valid_completed: int,
     *     not_completed: int,
     *     expired: int,
     *     expiring_soon: int,
     *     status: 'compliant'|'at_risk'|'overdue'|'unassigned'
     * }
     */
    public function summarizeUser(User $user): array
    {
        return $this->summarizeUsers(collect([$user]))->get($user->id, $this->summary(0, 0, 0, 0, 0, 'unassigned'));
    }

    /**
     * @param  Collection<int, int>  $userIds
     * @param  Collection<int, int>  $courseIds
     * @return array<int, array<int, CarbonInterface>>
     */
    private function latestPassedResultsByUserAndCourse(Collection $userIds, Collection $courseIds): array
    {
        if ($userIds->isEmpty() || $courseIds->isEmpty()) {
            return [];
        }

        $results = CourseResults::query()
            ->whereIn('user_id', $userIds)
            ->whereIn('course_id', $courseIds)
            ->where('passed', 1)
            ->selectRaw('user_id, course_id, MAX(created_at) as created_at')
            ->groupBy('user_id', 'course_id')
            ->get();

        $latestResults = [];

        foreach ($results as $result) {
            $latestResults[(int) $result->user_id][(int) $result->course_id] = $result->created_at;
        }

        return $latestResults;
    }

    /**
     * @return 'compliant'|'at_risk'|'overdue'|'unassigned'
     *
     * @phpstan-return TrainingComplianceStatus
     */
    private function resolveStatus(int $totalRequired, int $notCompleted, int $expired, int $expiringSoon): string
    {
        if ($totalRequired === 0) {
            return 'unassigned';
        }

        if ($expired > 0) {
            return 'overdue';
        }

        if ($notCompleted > 0 || $expiringSoon > 0) {
            return 'at_risk';
        }

        return 'compliant';
    }

    /**
     * @param  'compliant'|'at_risk'|'overdue'|'unassigned'  $status
     *
     * @phpstan-param  TrainingComplianceStatus  $status
     *
     * @return array{
     *     total_required: int,
     *     valid_completed: int,
     *     not_completed: int,
     *     expired: int,
     *     expiring_soon: int,
     *     status: 'compliant'|'at_risk'|'overdue'|'unassigned'
     * }
     *
     * @phpstan-return array{
     *     total_required: int,
     *     valid_completed: int,
     *     not_completed: int,
     *     expired: int,
     *     expiring_soon: int,
     *     status: TrainingComplianceStatus
     * }
     */
    private function summary(int $totalRequired, int $validCompleted, int $notCompleted, int $expired, int $expiringSoon, string $status): array
    {
        return [
            'total_required' => $totalRequired,
            'valid_completed' => $validCompleted,
            'not_completed' => $notCompleted,
            'expired' => $expired,
            'expiring_soon' => $expiringSoon,
            'status' => $status,
        ];
    }
}
