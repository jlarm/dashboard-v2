<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

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
                ->filter(function ($result) use ($oneYearAgo, $threeYearsAgo) {
                    return $result->created_at >= $oneYearAgo
                        || (in_array($result->course_id, [9, 10, 11, 12]) && $result->created_at >= $threeYearsAgo);
                })
                ->unique('course_id')
                ->count();
        }

        return CourseResults::query()
            ->distinct()
            ->where('user_id', $this->id)
            ->whereIn('course_id', $this->totalUserCourses())
            ->where(function ($query) {
                $query->where('created_at', '>=', now()->subYear())
                    ->orWhere(function ($query) {
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
        return $this->belongsToMany(Course::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(CourseResults::class);
    }

    private function totalUserCourses(): array
    {
        if (is_null($this->userCourses)) {
            // Ensure roles are loaded
            if (! $this->relationLoaded('roles')) {
                $this->load('roles');
            }

            $userRoles = $this->roles->pluck('id')->reject(fn ($id) => $id === 5);

            if ($userRoles->isEmpty()) {
                return [];
            }

            $courseWithRole = DB::table('course_role')
                ->whereIn('role_id', $userRoles)
                ->pluck('course_id')
                ->toArray();

            // Check for specific roles using loaded collection
            $hasManagerRole = $this->roles->contains('id', 10);
            $hasEmployeeRole = $this->roles->contains('id', 9);
            $hasNoCaliforniaStore = $this->userHasNoCaliforniaStore();

            $this->userCourses = Course::query()
                ->with('departments')
                ->where('optional', false)
                ->where(function ($query) use ($courseWithRole, $hasManagerRole, $hasEmployeeRole, $hasNoCaliforniaStore) {
                    $query->where(function ($q) use ($courseWithRole) {
                        $q->whereHas('departments', fn ($q) => $q->where('id', $this->department_id))
                            ->whereIn('id', $courseWithRole);
                    })
                        ->orWhere(function ($q) use ($hasManagerRole, $hasEmployeeRole, $hasNoCaliforniaStore) {
                            $q->whereDoesntHave('departments')
                                ->when($hasManagerRole, fn ($q) => $q->where('slug', '!=', 'sexual-harassment-m'))
                                ->when($hasEmployeeRole, fn ($q) => $q->where('slug', '!=', 'sexual-harassment-e'))
                                ->when($hasNoCaliforniaStore, fn ($q) => $q->where('slug', '!=', 'sexual-harassment-training-in-california'));
                        });
                })
                ->orWhere(function ($query) {
                    $query->whereHas('users', fn ($q) => $q->where('users.id', $this->id))
                        ->where('optional', false);
                })
                ->pluck('id')
                ->toArray();
        }

        return $this->userCourses;
    }
}
