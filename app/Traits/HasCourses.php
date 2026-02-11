<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\User;
use App\Services\UserCourseService;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin User
 *
 * @property int $total_user_courses
 */
trait HasCourses
{
    private $userCourses;

    /**
     * Clear the cached user courses data.
     * Call this method after modifying course results to refresh the count.
     */
    public function clearCourseCache(): void
    {
        $this->userCourses = null;

        // Clear service-level caches for this user
        app(UserCourseService::class)->clearCacheForUser($this->id);

        // Clear Laravel's attribute cache for computed attributes
        if (isset($this->attributes['total_completed_courses'])) {
            unset($this->attributes['total_completed_courses']);
        }
        if (isset($this->attributes['total_user_courses'])) {
            unset($this->attributes['total_user_courses']);
        }
    }

    public function getTotalCompletedCoursesAttribute(): int
    {
        // If results are already loaded, use them to avoid additional query
        if ($this->relationLoaded('results')) {
            $oneYearAgo = now()->subYear();
            $threeYearsAgo = now()->subYears(3);
            $userCourseIds = $this->totalUserCourses();

            return $this->results
                ->whereIn('course_id', $userCourseIds)
                ->where('passed', 1)
                ->filter(fn ($result): bool => $result->created_at >= $oneYearAgo
                    || (in_array($result->course_id, [9, 10, 11, 12]) && $result->created_at >= $threeYearsAgo))
                ->unique('course_id')
                ->count();
        }

        return CourseResults::query()
            ->distinct()
            ->where('user_id', $this->id)
            ->whereIn('course_id', $this->totalUserCourses())
            ->where(function ($query): void {
                $query->where('created_at', '>=', now()->subYear())
                    ->orWhere(function ($query): void {
                        $query->whereIn('course_id', [9, 10, 11, 12])
                            ->where('created_at', '>=', now()->subYears(3));
                    });
            })
            ->where('passed', 1)
            ->select('course_id')
            ->count('course_id');
    }

    public function getTotalUserCoursesAttribute(): int
    {
        return count($this->totalUserCourses());
    }

    public function getUserHasNotCompletedCoursesAttribute(): bool
    {
        return $this->total_completed_courses !== $this->total_user_courses;
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class)
            ->withPivot(['type', 'assigned_by']);
    }

    public function results(): HasMany
    {
        return $this->hasMany(CourseResults::class);
    }

    private function totalUserCourses(): array
    {
        if (is_null($this->userCourses)) {
            if (! $this->relationLoaded('roles')) {
                $this->load('roles');
            }

            $service = app(UserCourseService::class);
            $this->userCourses = $service->getCourseIds($this);
        }

        return $this->userCourses;
    }
}
