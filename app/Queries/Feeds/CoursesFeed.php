<?php

declare(strict_types=1);

namespace App\Queries\Feeds;

use App\Models\Dealer\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final readonly class CoursesFeed
{
    private readonly Collection $roles;
    private readonly Collection $userStates;

    public function __construct(
        private readonly User $user,
    ) {
        $this->user->load(['roles', 'stores', 'department']);
        $this->roles = $this->user->roles->pluck('id');
        $this->userStates = $this->user->stores->pluck('state');
    }

    public function builder(): Builder
    {
        return Course::query()
            ->select(['id', 'name', 'slug', 'years_expires'])
            ->withLastResult($this->user->id)
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('optional', false)
                        ->doesntHave('departments')
                        ->doesntHave('roles');

                    if (! $this->isCaliforniaUser()) {
                        $q->where('slug', '!=', 'sexual-harassment-training-in-california');
                    }
                })
                    ->orWhereHas('users', function ($q) {
                        $q->where('users.id', $this->user->id);
                    })
                    ->orWhere(function ($q) {
                        $q->whereHas('departments', function ($dq) {
                            $dq->where('departments.id', $this->user->department_id);
                        })->whereHas('roles', function ($rq) {
                            $rq->whereIn('roles.id', $this->roles);
                        });
                    })
                    ->orWhere(function ($q) {
                        $q->whereHas('roles', function ($rq) {
                            $rq->whereIn('roles.id', $this->roles);
                        })->doesntHave('departments');
                    });
            });
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
        $completedCount = $courses->filter(fn ($course) => $course->lastResult !== null)->count();
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
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('course_results')
                    ->whereColumn('course_results.course_id', 'courses.id')
                    ->where('course_results.user_id', $this->user->id);
            })
            ->count();

        $incompleteCount = $totalCount - $completedCount;

        return [
            'total' => $totalCount,
            'completed' => $completedCount,
            'incomplete' => $incompleteCount,
        ];
    }

    private function isCaliforniaUser(): bool
    {
        return $this->userStates->contains('California');
    }
}
