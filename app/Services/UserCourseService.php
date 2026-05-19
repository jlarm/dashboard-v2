<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Course as CentralCourse;
use App\Models\Dealer\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class UserCourseService
{
    private const array ADMIN_ROLES = ['super-admin', 'Admin', 'Consultant', 'Qualified Individual'];

    private const int QUALIFIED_INDIVIDUAL_ROLE_ID = 5;
    private const array STATE_ALIASES = [
        'al' => 'alabama',
        'ak' => 'alaska',
        'az' => 'arizona',
        'ar' => 'arkansas',
        'ca' => 'california',
        'co' => 'colorado',
        'ct' => 'connecticut',
        'de' => 'delaware',
        'fl' => 'florida',
        'ga' => 'georgia',
        'hi' => 'hawaii',
        'id' => 'idaho',
        'il' => 'illinois',
        'in' => 'indiana',
        'ia' => 'iowa',
        'ks' => 'kansas',
        'ky' => 'kentucky',
        'la' => 'louisiana',
        'me' => 'maine',
        'md' => 'maryland',
        'ma' => 'massachusetts',
        'mi' => 'michigan',
        'mn' => 'minnesota',
        'ms' => 'mississippi',
        'mo' => 'missouri',
        'mt' => 'montana',
        'ne' => 'nebraska',
        'nv' => 'nevada',
        'nh' => 'new hampshire',
        'nj' => 'new jersey',
        'nm' => 'new mexico',
        'ny' => 'new york',
        'nc' => 'north carolina',
        'nd' => 'north dakota',
        'oh' => 'ohio',
        'ok' => 'oklahoma',
        'or' => 'oregon',
        'pa' => 'pennsylvania',
        'ri' => 'rhode island',
        'sc' => 'south carolina',
        'sd' => 'south dakota',
        'tn' => 'tennessee',
        'tx' => 'texas',
        'ut' => 'utah',
        'vt' => 'vermont',
        'va' => 'virginia',
        'wa' => 'washington',
        'wv' => 'west virginia',
        'wi' => 'wisconsin',
        'wy' => 'wyoming',
    ];

    private array $courseIdsCache = [];
    private array $courseRoleCache = [];
    private array $baseCourseCache = [];
    private ?array $tenantAssignedSlugsCache = null;
    private int|string|null $tenantSlugsCachedFor = null;
    private int|string|null $currentTenantId = null;

    public function clearCacheForUser(?int $userId): void
    {
        if ($userId === null) {
            return;
        }

        unset($this->courseIdsCache[$userId]);
        $this->courseRoleCache = [];
        $this->baseCourseCache = [];
        $this->tenantAssignedSlugsCache = null;
        $this->tenantSlugsCachedFor = null;
    }

    public function clearAllCaches(): void
    {
        $this->courseIdsCache = [];
        $this->courseRoleCache = [];
        $this->baseCourseCache = [];
        $this->tenantAssignedSlugsCache = null;
        $this->tenantSlugsCachedFor = null;
    }

    public function getCourseIds(User $user): array
    {
        $this->resetCachesIfTenantChanged();

        if (isset($this->courseIdsCache[$user->id])) {
            return $this->courseIdsCache[$user->id];
        }

        $userRoleNames = $user->roles->pluck('name')->toArray();
        $hasOnlyAdminRoles = ! empty($userRoleNames) && array_diff($userRoleNames, self::ADMIN_ROLES) === [];

        if ($hasOnlyAdminRoles) {
            return $this->courseIdsCache[$user->id] = $this->applyTenantScope(
                $this->getOverrideCourseIds($user, 'add')
            );
        }

        $excludedCourseIds = $this->getOverrideCourseIds($user, 'exclude');
        $addedCourseIds = $this->getOverrideCourseIds($user, 'add');
        $userRoleIds = $user->roles
            ->reject(fn (mixed $role): bool => $role instanceof Role
                && ($role->id === self::QUALIFIED_INDIVIDUAL_ROLE_ID || in_array($role->name, self::ADMIN_ROLES, true)))
            ->pluck('id');

        if ($userRoleIds->isEmpty()) {
            return $this->courseIdsCache[$user->id] = [];
        }

        $roleKey = $userRoleIds->sort()->implode('_');

        $courseWithRole = $this->courseRoleCache[$roleKey] ??= Course::query()
            ->whereHas('roles', fn (Builder $query) => $query->whereIn('roles.id', $userRoleIds))
            ->pluck('id')
            ->toArray();

        $userStates = $this->getUserStates($user);
        $baseKey = $user->department_id.'|'.$roleKey.'|'.implode(',', $userStates);

        $baseCourseIds = $this->baseCourseCache[$baseKey] ??= $this->resolveBaseCourseIds(
            $user->department_id,
            $courseWithRole,
            $userStates
        );

        return $this->courseIdsCache[$user->id] = $this->applyTenantScope(
            collect($baseCourseIds)
                ->merge($addedCourseIds)
                ->unique()
                ->diff($excludedCourseIds)
                ->values()
                ->toArray()
        );
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
            ->with(['results' => fn (Relation $query) => $query->where('user_id', $user->id)->latest()])
            ->select(['id', 'name', 'slug'])
            ->orderBy('name')
            ->get();
    }

    public function getCoursesWithOptions(User $user, array $select = ['*'], array $with = []): Collection
    {
        $courseIds = $this->getCourseIds($user);

        return Course::query()
            ->whereIn('id', $courseIds)
            ->when($with, fn (Builder $query) => $query->with($with))
            ->select($select)
            ->orderBy('name')
            ->get();
    }

    public function normalizeState(string $state): string
    {
        $normalized = mb_strtolower(mb_trim($state));
        if ($normalized === '') {
            return '';
        }

        return self::STATE_ALIASES[$normalized] ?? $normalized;
    }

    /**
     * @return array<int>
     */
    private function resolveBaseCourseIds(mixed $departmentId, array $courseWithRole, array $userStates): array
    {
        $assignedSlugs = $this->getTenantAssignedCourseSlugs();

        $candidates = Course::query()
            ->where('optional', false)
            ->when($assignedSlugs !== null, fn (Builder $query) => $query->whereIn('slug', $assignedSlugs))
            ->where(function (Builder $query) use ($departmentId, $courseWithRole): void {
                $query->where(function (Builder $q) use ($departmentId, $courseWithRole): void {
                    $q->whereHas('departments', fn (Builder $q) => $q->where('id', $departmentId))
                        ->whereIn('id', $courseWithRole);
                })->orWhere(function (Builder $q) use ($courseWithRole): void {
                    $q->whereDoesntHave('departments')
                        ->where(function (Builder $subQuery) use ($courseWithRole): void {
                            $subQuery->whereIn('id', $courseWithRole)
                                ->orWhereDoesntHave('roles');
                        });
                });
            })
            ->get(['id', 'slug', 'states_required', 'replaces_course_slugs']);

        // State-specific courses that match at least one of the user's states
        $applicableStateCourses = $candidates->filter(
            fn (Course $course): bool => $this->statesOverlap($userStates, $course->states_required)
        );

        // Slugs of general courses that applicable state courses replace
        $replacedSlugs = $applicableStateCourses
            ->flatMap(fn (Course $course): array => $course->replaces_course_slugs ?? [])
            ->unique()
            ->all();

        return $candidates
            ->filter(function (Course $course) use ($userStates, $replacedSlugs): bool {
                // Exclude state-specific courses that don't apply to this user's states
                if ($course->states_required !== null && ! $this->statesOverlap($userStates, $course->states_required)) {
                    return false;
                }

                // Exclude general courses that have been superseded by a state-specific course
                return ! ($course->states_required === null && in_array($course->slug, $replacedSlugs, true));
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
        if ($user->primary_store_id !== null) {
            $primaryStore = $user->relationLoaded('primaryStore')
                ? $user->primaryStore
                : $user->primaryStore()->first();

            $state = $primaryStore?->state;

            return $state !== null
                ? array_filter([$this->normalizeState((string) $state)])
                : [];
        }

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
            ->map(fn (mixed $state): string => $this->normalizeState($state))
            ->filter()
            ->unique()
            ->values()
            ->all();

        return array_intersect($userStates, $normalizedRequiredStates) !== [];
    }

    /**
     * Detect a tenant switch (or end of tenancy) and flush any caches keyed
     * implicitly to the previous tenant. The role/base/per-user caches don't
     * include tenant in their keys because in normal request flow the service
     * lives inside a single tenant context — but a worker reused across
     * tenants (queue jobs, console commands) can change that.
     */
    private function resetCachesIfTenantChanged(): void
    {
        $tenantId = tenancy()->initialized ? tenant()?->id : null;

        if ($tenantId === $this->currentTenantId) {
            return;
        }

        $this->courseIdsCache = [];
        $this->courseRoleCache = [];
        $this->baseCourseCache = [];
        $this->tenantAssignedSlugsCache = null;
        $this->tenantSlugsCachedFor = null;
        $this->currentTenantId = $tenantId;
    }

    /**
     * Return slugs of central courses assigned to the current tenant, or null
     * when no tenant context is active (skip filtering — e.g. central calls).
     * Empty pivot on a central course = available to all tenants.
     *
     * @return array<int, string>|null
     */
    private function getTenantAssignedCourseSlugs(): ?array
    {
        if (! tenancy()->initialized) {
            return null;
        }

        $tenantId = tenant()?->id;

        if ($tenantId === null) {
            return null;
        }

        if ($this->tenantSlugsCachedFor === $tenantId && $this->tenantAssignedSlugsCache !== null) {
            return $this->tenantAssignedSlugsCache;
        }

        $slugs = CentralCourse::query()
            ->with('tenants:id')
            ->get(['id', 'slug'])
            ->filter(function (CentralCourse $course) use ($tenantId): bool {
                $assignedIds = $course->tenants->pluck('id')->all();

                return $assignedIds === [] || in_array($tenantId, $assignedIds, true);
            })
            ->pluck('slug')
            ->values()
            ->all();

        $this->tenantSlugsCachedFor = $tenantId;

        return $this->tenantAssignedSlugsCache = $slugs;
    }

    /**
     * Intersect a list of tenant course IDs with the slugs assigned to the
     * current tenant. Returns the input unchanged when no tenant context.
     *
     * @param  array<int, int>  $courseIds
     * @return array<int, int>
     */
    private function applyTenantScope(array $courseIds): array
    {
        if ($courseIds === []) {
            return [];
        }

        $assignedSlugs = $this->getTenantAssignedCourseSlugs();

        if ($assignedSlugs === null) {
            return $courseIds;
        }

        return Course::query()
            ->whereIn('id', $courseIds)
            ->whereIn('slug', $assignedSlugs)
            ->pluck('id')
            ->all();
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
