<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Dealer\Course;
use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class UserCourseService
{
    private const ADMIN_ROLES = ['super-admin', 'Admin', 'Consultant', 'Qualified Individual'];

    private const QUALIFIED_INDIVIDUAL_ROLE_ID = 5;

    private array $courseIdsCache = [];
    private array $courseRoleCache = [];
    private array $baseCourseCache = [];

    public function clearCacheForUser(?int $userId): void
    {
        if ($userId === null) {
            return;
        }

        unset($this->courseIdsCache[$userId]);
        $this->courseRoleCache = [];
        $this->baseCourseCache = [];
    }

    public function clearAllCaches(): void
    {
        $this->courseIdsCache = [];
        $this->courseRoleCache = [];
        $this->baseCourseCache = [];
    }

    public function getCourseIds(User $user): array
    {
        if (isset($this->courseIdsCache[$user->id])) {
            return $this->courseIdsCache[$user->id];
        }

        $userRoleNames = $user->roles->pluck('name')->toArray();
        $hasOnlyAdminRoles = ! empty($userRoleNames) && array_diff($userRoleNames, self::ADMIN_ROLES) === [];

        if ($hasOnlyAdminRoles) {
            return $this->courseIdsCache[$user->id] = $this->getOverrideCourseIds($user, 'add');
        }

        $excludedCourseIds = $this->getOverrideCourseIds($user, 'exclude');
        $addedCourseIds = $this->getOverrideCourseIds($user, 'add');
        $userRoleIds = $user->roles
            ->reject(fn (Role $role): bool => $role->id === self::QUALIFIED_INDIVIDUAL_ROLE_ID || in_array($role->name, self::ADMIN_ROLES))
            ->pluck('id');

        if ($userRoleIds->isEmpty()) {
            return $this->courseIdsCache[$user->id] = [];
        }

        $roleKey = $userRoleIds->sort()->implode('_');

        $courseWithRole = $this->courseRoleCache[$roleKey] ??= Course::query()
            ->whereHas('roles', fn ($query) => $query->whereIn('roles.id', $userRoleIds))
            ->pluck('id')
            ->toArray();

        $hasNoCaliforniaStore = $this->userHasNoCaliforniaStore($user);

        $baseKey = $user->department_id.'|'.$roleKey.'|'.($hasNoCaliforniaStore ? 'no-ca' : 'ca');

        $baseCourseIds = $this->baseCourseCache[$baseKey] ??= Course::query()
            ->where('optional', false)
            ->where(function ($query) use ($user, $courseWithRole, $hasNoCaliforniaStore): void {
                $query->where(function ($q) use ($user, $courseWithRole): void {
                    $q->whereHas('departments', fn ($q) => $q->where('id', $user->department_id))
                        ->whereIn('id', $courseWithRole);
                })
                    ->orWhere(function ($q) use ($courseWithRole, $hasNoCaliforniaStore): void {
                        $q->whereDoesntHave('departments')
                            ->where(function ($subQuery) use ($courseWithRole): void {
                                $subQuery->whereIn('id', $courseWithRole)
                                    ->orWhereDoesntHave('roles');
                            })
                            ->when($hasNoCaliforniaStore, fn ($q) => $q->where('slug', '!=', Course::CALIFORNIA_TRAINING_SLUG));
                    });
            })
            ->pluck('id')
            ->toArray();

        return $this->courseIdsCache[$user->id] = collect($baseCourseIds)
            ->merge($addedCourseIds)
            ->unique()
            ->diff($excludedCourseIds)
            ->values()
            ->toArray();
    }

    public function getCoursesSimple(User $user): Collection
    {
        $courseIds = $this->getCourseIds($user);

        return Course::query()
            ->whereIn('id', $courseIds)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }

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

    public function getCoursesWithOptions(User $user, array $select = ['*'], array $with = []): Collection
    {
        $courseIds = $this->getCourseIds($user);

        return Course::query()
            ->whereIn('id', $courseIds)
            ->when($with, fn ($query) => $query->with($with))
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
