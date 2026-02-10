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
        // Admin roles should never be assigned courses automatically
        $adminRoles = ['super-admin', 'Admin', 'Consultant', 'Qualified Individual'];
        $userRoleNames = $user->roles->pluck('name')->toArray();
        $hasOnlyAdminRoles = ! empty($userRoleNames) && empty(array_diff($userRoleNames, $adminRoles));

        if ($hasOnlyAdminRoles) {
            // Admin users only get manually added courses
            return $this->getOverrideCourseIds($user, 'add');
        }

        // Get courses explicitly excluded for this user
        $excludedCourseIds = $this->getOverrideCourseIds($user, 'exclude');

        // Get courses explicitly added for this user
        $addedCourseIds = $this->getOverrideCourseIds($user, 'add');

        // Get user role IDs (excluding role 5 and admin roles)
        $userRoleIds = $user->roles
            ->reject(fn ($role) => $role->id === 5 || in_array($role->name, $adminRoles))
            ->pluck('id');

        if ($userRoleIds->isEmpty()) {
            return [];
        }

        // Get course IDs associated with user's roles
        $courseWithRole = DB::table('course_role')
            ->whereIn('role_id', $userRoleIds)
            ->pluck('course_id')
            ->toArray();

        // Check for specific roles by name (not hard-coded IDs)
        $hasManagerRole = $user->hasRole('Manager');
        $hasEmployeeRole = $user->hasRole('Employee');
        $hasNoCaliforniaStore = $this->userHasNoCaliforniaStore($user);

        // Get base courses from department and role
        $baseCourseIds = Course::query()
            ->where('optional', false)
            ->where(function ($query) use ($user, $courseWithRole, $hasNoCaliforniaStore) {
                // Branch 1: Courses with specific departments (must have matching role)
                $query->where(function ($q) use ($user, $courseWithRole) {
                    $q->whereHas('departments', fn ($q) => $q->where('id', $user->department_id))
                        ->whereIn('id', $courseWithRole);
                })
                    // Branch 2: Courses without departments
                    ->orWhere(function ($q) use ($courseWithRole, $hasNoCaliforniaStore) {
                        $q->whereDoesntHave('departments')
                            ->where(function ($subQuery) use ($courseWithRole) {
                                // Either has a role requirement AND user has that role
                                $subQuery->whereIn('id', $courseWithRole)
                                    // OR has no role requirement (universal course for everyone)
                                    ->orWhereDoesntHave('roles');
                            })
                            // Only exclude California-specific course for users without California stores
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

    private function getOverrideCourseIds(User $user, string $type): array
    {
        if ($user->relationLoaded('courseOverrides')) {
            return $user->courseOverrides
                ->where('type', $type)
                ->pluck('course_id')
                ->values()
                ->all();
        }

        return $user->courseOverrides()
            ->where('type', $type)
            ->pluck('course_id')
            ->toArray();
    }
}
