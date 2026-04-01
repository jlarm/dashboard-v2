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
    private const STATE_ALIASES = [
        'il' => 'illinois',
        'ca' => 'california',
    ];

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
            ->reject(fn ($role): bool => $role instanceof Role
                && ($role->id === self::QUALIFIED_INDIVIDUAL_ROLE_ID || in_array($role->name, self::ADMIN_ROLES, true)))
            ->pluck('id');

        if ($userRoleIds->isEmpty()) {
            return $this->courseIdsCache[$user->id] = [];
        }

        $roleKey = $userRoleIds->sort()->implode('_');

        $courseWithRole = $this->courseRoleCache[$roleKey] ??= Course::query()
            ->whereHas('roles', fn ($query) => $query->whereIn('roles.id', $userRoleIds))
            ->pluck('id')
            ->toArray();

        $userStates = $this->getUserStates($user);
        $baseKey = $user->department_id.'|'.$roleKey.'|'.implode(',', $userStates);

        $baseCourseIds = $this->baseCourseCache[$baseKey] ??= $this->resolveBaseCourseIds(
            $user->department_id,
            $courseWithRole,
            $userStates
        );

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

    /**
     * @return array<int>
     */
    private function resolveBaseCourseIds(mixed $departmentId, array $courseWithRole, array $userStates): array
    {
        $candidates = Course::query()
            ->where('optional', false)
            ->where(function ($query) use ($departmentId, $courseWithRole): void {
                $query->where(function ($q) use ($departmentId, $courseWithRole): void {
                    $q->whereHas('departments', fn ($q) => $q->where('id', $departmentId))
                        ->whereIn('id', $courseWithRole);
                })->orWhere(function ($q) use ($courseWithRole): void {
                    $q->whereDoesntHave('departments')
                        ->where(function ($subQuery) use ($courseWithRole): void {
                            $subQuery->whereIn('id', $courseWithRole)
                                ->orWhereDoesntHave('roles');
                        });
                });
            })
            ->get(['id', 'slug', 'states_required', 'replaces_course_slugs']);

        // State-specific courses that match at least one of the user's states
        $applicableStateCourses = $candidates->filter(
            fn ($course): bool => $this->statesOverlap($userStates, $course->states_required)
        );

        // Slugs of general courses that applicable state courses replace
        $replacedSlugs = $applicableStateCourses
            ->flatMap(fn ($course): array => $course->replaces_course_slugs ?? [])
            ->unique()
            ->all();

        return $candidates
            ->filter(function ($course) use ($userStates, $replacedSlugs): bool {
                // Exclude state-specific courses that don't apply to this user's states
                if ($course->states_required !== null && ! $this->statesOverlap($userStates, $course->states_required)) {
                    return false;
                }

                // Exclude general courses that have been superseded by a state-specific course
                if ($course->states_required === null && in_array($course->slug, $replacedSlugs, true)) {
                    return false;
                }

                return true;
            })
            ->pluck('id')
            ->values()
            ->toArray();
    }

    /**
     * @return array<string>
     */
    private function getUserStates(User $user): array
    {
        $states = $user->relationLoaded('stores')
            ? $user->stores->pluck('state')->filter()->all()
            : $user->stores()->distinct()->orderBy('state')->pluck('state')->filter()->toArray();

        return collect($states)
            ->map(fn (mixed $state): string => $this->normalizeState((string) $state))
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    /**
     * @param  array<string>  $userStates
     * @param  array<string>|null  $requiredStates
     */
    private function statesOverlap(array $userStates, ?array $requiredStates): bool
    {
        if ($requiredStates === null || $requiredStates === []) {
            return false;
        }

        $normalizedRequiredStates = collect($requiredStates)
            ->map(fn (mixed $state): string => $this->normalizeState((string) $state))
            ->filter()
            ->unique()
            ->values()
            ->all();

        return count(array_intersect($userStates, $normalizedRequiredStates)) > 0;
    }

    private function normalizeState(string $state): string
    {
        $normalized = mb_strtolower(trim($state));
        if ($normalized === '') {
            return '';
        }

        return self::STATE_ALIASES[$normalized] ?? $normalized;
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
