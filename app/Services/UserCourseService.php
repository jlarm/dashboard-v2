<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Dealer\Course;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserCourseService
{
    /**
     * Get the IDs of courses assigned to a user.
     * This is the core logic that determines which courses a user should have.
     */
    public function getCourseIds(User $user): array
    {
        // Get courses explicitly excluded for this user
        $excludedCourseIds = $user->courseOverrides()
            ->where('type', 'exclude')
            ->pluck('course_id')
            ->toArray();

        // Get courses explicitly added for this user
        $addedCourseIds = $user->courseOverrides()
            ->where('type', 'add')
            ->pluck('course_id')
            ->toArray();

        // Get user role IDs (excluding role 5)
        $userRoleIds = $user->roles->pluck('id')->reject(fn ($id) => $id === 5);

        if ($userRoleIds->isEmpty()) {
            return [];
        }

        // Get course IDs associated with user's roles
        $courseWithRole = DB::table('course_role')
            ->whereIn('role_id', $userRoleIds)
            ->pluck('course_id')
            ->toArray();

        // Check for specific roles
        $hasManagerRole = $user->roles->contains('id', 10);
        $hasEmployeeRole = $user->roles->contains('id', 9);
        $hasNoCaliforniaStore = $this->userHasNoCaliforniaStore($user);

        // Get base courses from department and role
        $baseCourseIds = Course::query()
            ->where('optional', false)
            ->where(function ($query) use ($user, $courseWithRole, $hasManagerRole, $hasEmployeeRole, $hasNoCaliforniaStore) {
                $query->where(function ($q) use ($user, $courseWithRole) {
                    $q->whereHas('departments', fn ($q) => $q->where('id', $user->department_id))
                        ->whereIn('id', $courseWithRole);
                })
                    ->orWhere(function ($q) use ($hasManagerRole, $hasEmployeeRole, $hasNoCaliforniaStore) {
                        $q->whereDoesntHave('departments')
                            ->when($hasManagerRole, fn ($q) => $q->where('slug', '!=', 'sexual-harassment-m'))
                            ->when($hasEmployeeRole, fn ($q) => $q->where('slug', '!=', 'sexual-harassment-e'))
                            ->when($hasNoCaliforniaStore, fn ($q) => $q->where('slug', '!=', 'sexual-harassment-training-in-california'));
                    });
            })
            ->pluck('id')
            ->toArray();

        // Merge base courses with added courses, then remove excluded courses
        return collect($baseCourseIds)
            ->merge($addedCourseIds)
            ->unique()
            ->diff($excludedCourseIds)
            ->values()
            ->toArray();
    }

    /**
     * Get simple course data (id, name) for dropdowns/lists.
     */
    public function getCoursesSimple(User $user): Collection
    {
        $courseIds = $this->getCourseIds($user);

        return Course::query()
            ->whereIn('id', $courseIds)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    /**
     * Get full course models with results relationship for display.
     */
    public function getCoursesWithResults(User $user): Collection
    {
        $courseIds = $this->getCourseIds($user);

        return Course::query()
            ->whereIn('id', $courseIds)
            ->with(['results' => fn ($query) => $query->where('user_id', $user->id)->latest()])
            ->select(['id', 'name', 'slug'])
            ->orderBy('name')
            ->get();
    }

    /**
     * Get courses with custom select and relationships.
     */
    public function getCoursesWithOptions(User $user, array $select = ['*'], array $with = []): Collection
    {
        $courseIds = $this->getCourseIds($user);

        return Course::query()
            ->whereIn('id', $courseIds)
            ->when(! empty($with), fn ($query) => $query->with($with))
            ->select($select)
            ->orderBy('name')
            ->get();
    }

    private function userHasNoCaliforniaStore(User $user): bool
    {
        if ($user->relationLoaded('stores')) {
            return ! $user->stores->contains('state', 'California');
        }

        return ! $user->stores()->where('state', 'California')->exists();
    }
}
