<?php

namespace App\Traits;

use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

trait HasCourses
{
    private $userCourses;

    private function totalUserCourses(): array
    {
        if (is_null($this->userCourses)) {
            $this->load('roles');

            $userRoles = $this->roles->pluck('id')->reject(fn ($id) => $id == 5);

            if ($userRoles->isEmpty()) {
                return [];
            }

            $courseWithRole = DB::table('course_role')
                ->whereIn('role_id', $userRoles)
                ->pluck('course_id')
                ->toArray();

            $this->userCourses = Course::query()
                ->with('departments')
                ->where('optional', false)
                ->where(function ($query) use ($courseWithRole) {
                    $query->where(function ($q) use ($courseWithRole) {
                        $q->whereHas('departments', fn ($q) => $q->where('id', $this->department_id))
                            ->whereIn('id', $courseWithRole);
                    })
                        ->orWhere(function ($q) {
                            $q->whereDoesntHave('departments')
                                ->when($this->roles()->where('id', 10)->exists(), fn ($q) => $q->where('slug', '!=', 'sexual-harassment-m'))
                                ->when($this->roles()->where('id', 9)->exists(), fn ($q) => $q->where('slug', '!=', 'sexual-harassment-e'))
                                ->when($this->userHasNoCaliforniaStore(), fn ($q) => $q->where('slug', '!=', 'sexual-harassment-training-in-california'));
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

    public function getTotalCompletedCoursesAttribute(): int
    {
        return DB::table('course_results')
            ->distinct()
            ->select('course_id')
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
            ->count('course_id');
    }

    public function getTotalUserCoursesAttribute(): int
    {
        return count($this->totalUserCourses());
    }

    public function getUserHasNotCompletedCoursesAttribute(): bool
    {
        return $this->total_completed_courses != $this->total_user_courses;
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(CourseResults::class);
    }
}
