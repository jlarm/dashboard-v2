<?php

declare(strict_types=1);

namespace App\Queries\Feeds;

use App\Models\Dealer\Course;
use App\Models\User;
use App\Services\UserCourseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final readonly class CoursesFeed
{
    private readonly UserCourseService $userCourseService;

    public function __construct(
        private readonly User $user,
    ) {
        $this->userCourseService = app(UserCourseService::class);
    }

    public function builder(): Builder
    {
        $courseIds = $this->userCourseService->getCourseIds($this->user);

        return Course::query()
            ->select(['id', 'name', 'slug', 'years_expires'])
            ->withLastResult($this->user->id)
            ->whereIn('id', $courseIds);
    }

    /**
     * Get course completion statistics for the user
     *
     * @return array{total: int, completed: int, incomplete: int}
     */
    public function getCourseCompletionStats(): array
    {
        $courses = $this->builder()->get();

        $totalCount = $courses->count();
        $completedCount = $courses->filter(fn (Course $course): bool => $course->lastResult !== null)->count();
        $incompleteCount = $totalCount - $completedCount;

        return [
            'total' => $totalCount,
            'completed' => $completedCount,
            'incomplete' => $incompleteCount,
        ];
    }

    /**
     * Get course completion counts using direct queries rather than relying on last_result_id
     *
     * @return array{total: int, completed: int, incomplete: int}
     */
    public function getCourseCounts(): array
    {
        // Get all applicable courses for the user
        $baseQuery = $this->builder();

        // Clone the query to avoid modifying the original
        $totalQuery = clone $baseQuery;
        $completedQuery = clone $baseQuery;

        $totalCount = $totalQuery->count();

        // Correctly query for completed courses by checking course_results table directly
        $completedCount = $completedQuery
            ->whereExists(function ($query): void {
                $query->select(DB::raw(1))
                    ->from('course_results')
                    ->whereColumn('course_results.course_id', 'courses.id')
                    ->where('course_results.user_id', $this->user->id)
                    ->whereNull('course_results.deleted_at');
            })
            ->count();

        $incompleteCount = $totalCount - $completedCount;

        return [
            'total' => $totalCount,
            'completed' => $completedCount,
            'incomplete' => $incompleteCount,
        ];
    }
}
