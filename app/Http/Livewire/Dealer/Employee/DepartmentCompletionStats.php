<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Store;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Component;
use Override;

class DepartmentCompletionStats extends Component
{
    private const array DEPARTMENTS = [
        'all' => ['id' => null, 'name' => 'All'],
        'sales' => ['id' => 1, 'name' => 'Sales'],
        'accounting' => ['id' => 2, 'name' => 'Accounting'],
        'service' => ['id' => 3, 'name' => 'Service'],
        'parts' => ['id' => 4, 'name' => 'Parts'],
        'bodyShop' => ['id' => 5, 'name' => 'Body Shop'],
        'finance' => ['id' => 6, 'name' => 'Finance'],
        'porterDriver' => ['id' => 7, 'name' => 'Porter/Driver'],
    ];

    public ?Store $store = null;
    public bool $readyToLoad = false;
    public array $stats = [];

    #[Override]
    protected $listeners = ['refreshEmployeeDetails' => 'clearCacheAndRefresh'];

    /**
     * Forget every department-completion-stats cache key for the currently-initialized tenant.
     * Safe to call from any tenant context (Import, Edit, Reconcile, etc.).
     */
    public static function flushCacheForCurrentTenant(?int $storeId = null): void
    {
        $tenantId = tenant('id') ?? 'no-tenant';
        $storeIds = [];

        try {
            $storeIds = $storeId !== null
                ? [$storeId]
                : Store::query()->pluck('id')->toArray();
        } catch (Exception $e) {
            Log::warning('Failed to fetch store IDs for cache clearing', [
                'error' => $e->getMessage(),
                'tenant_id' => $tenantId,
            ]);
            $storeIds = [];
        }

        foreach ($storeIds as $sid) {
            Cache::forget("department_completion_stats_{$sid}_{$tenantId}");
        }

        Cache::forget("department_completion_stats_all_{$tenantId}_admin");

        try {
            $allUsers = User::with('stores')->get();
            foreach ($allUsers as $user) {
                if (! $user->hasAnyRole(['super-admin', 'Consultant'])) {
                    $userStoreIds = $user->stores->pluck('id')->sort()->implode('_');
                    Cache::forget("department_completion_stats_all_{$tenantId}_user_{$userStoreIds}");
                }
            }
        } catch (Exception $e) {
            Log::warning('Failed to clear user-specific department completion caches', [
                'error' => $e->getMessage(),
                'tenant_id' => $tenantId,
            ]);
        }
    }

    public function loadStats(): void
    {
        $this->readyToLoad = true;
        $this->stats = $this->calculateAllStats();
    }

    public function clearCacheAndRefresh(): void
    {
        $this->clearAllCachesForTenantAndStore();

        if ($this->readyToLoad) {
            $this->stats = $this->calculateAllStats();
        }
    }

    public function render(): View
    {
        return view('livewire.dealer.employee.department-completion-stats', [
            'departments' => self::DEPARTMENTS,
        ]);
    }

    protected function clearAllCachesForTenantAndStore(): void
    {
        self::flushCacheForCurrentTenant($this->store?->id);
    }

    protected function calculateAllStats(): array
    {
        $cacheKey = $this->getCacheKey();

        return Cache::remember($cacheKey, 300, function (): array {
            $oneYearAgo = now()->subYear();
            $threeYearsAgo = now()->subYears(3);

            $allUsers = $this->buildBaseQuery()
                ->whereHas('roles', function ($q): void {
                    $q->where('id', '!=', 5);
                })
                ->with([
                    'roles:id,name',
                    'stores:id,state',
                    'courseOverrides:user_id,course_id,type',
                    'results' => function ($q) use ($oneYearAgo, $threeYearsAgo): void {
                        $q->select('id', 'user_id', 'course_id', 'passed', 'created_at')
                            ->where('passed', 1)
                            ->where(function ($query) use ($oneYearAgo, $threeYearsAgo): void {
                                $query->where('created_at', '>=', $oneYearAgo)
                                    ->orWhere(function ($query) use ($threeYearsAgo): void {
                                        $query->whereIn('course_id', [9, 10, 11, 12])
                                            ->where('created_at', '>=', $threeYearsAgo);
                                    });
                            })
                            ->whereNull('deleted_at');
                    },
                ])
                ->get();

            $stats = [];

            foreach (self::DEPARTMENTS as $key => $department) {
                $departmentId = $department['id'];

                $users = $departmentId === null
                    ? $allUsers
                    : $allUsers->where('department_id', $departmentId);

                $stats[$key] = $this->calculateDepartmentStat($users, $department['name']);
            }

            return $stats;
        });
    }

    /**
     * @param  Collection<int, User>  $users
     * @return array{name: string, total: int, incomplete: int, percentage: int}
     */
    protected function calculateDepartmentStat(Collection $users, string $name): array
    {
        $totalCount = 0;
        $completedCount = 0;

        foreach ($users as $user) {
            if ($user->total_user_courses === 0) {
                continue;
            }

            $totalCount++;

            if (! $user->user_has_not_completed_courses) {
                $completedCount++;
            }
        }

        if ($totalCount === 0) {
            return ['name' => $name, 'total' => 0, 'incomplete' => 0, 'percentage' => 0];
        }

        return [
            'name' => $name,
            'total' => $totalCount,
            'incomplete' => $totalCount - $completedCount,
            'percentage' => (int) round(($completedCount / $totalCount) * 100),
        ];
    }

    protected function buildBaseQuery(): Builder
    {
        $query = User::query();
        $scopedStoreIds = $this->resolveScopedStoreIds();

        if ($scopedStoreIds->isNotEmpty()) {
            $query->whereHas('stores', function ($q) use ($scopedStoreIds): void {
                $q->whereIn('stores.id', $scopedStoreIds);
            });
        } elseif (auth()->user() instanceof User) {
            $query->whereRaw('1 = 0');
        }

        $excludedUsers = config('dashboard.excluded_users', []);

        if (! empty($excludedUsers)) {
            $query->whereNotIn('name', $excludedUsers);
        }

        return $query;
    }

    protected function getCacheKey(): string
    {
        $tenantId = tenant('id') ?? 'no-tenant';
        $scopedStoreIds = $this->resolveScopedStoreIds();
        $user = auth()->user();

        if ($this->store instanceof Store) {
            return "department_completion_stats_{$this->store->id}_{$tenantId}";
        }

        if (
            $scopedStoreIds->count() === 1
            && ($this->boundScopedStoreIds()->isNotEmpty() || ($user instanceof User && $user->current_store_id !== null))
        ) {
            return 'department_completion_stats_'.$scopedStoreIds->first().'_'.$tenantId;
        }

        if ($user instanceof User && $user->hasAnyRole(['super-admin', 'Consultant'])) {
            return "department_completion_stats_all_{$tenantId}_admin";
        }

        $userStoreIds = $scopedStoreIds->sort()->implode('_');

        return "department_completion_stats_all_{$tenantId}_user_{$userStoreIds}";
    }

    /**
     * @return Collection<int, int>
     */
    protected function resolveScopedStoreIds(): Collection
    {
        if ($this->store instanceof Store) {
            return collect([$this->store->id]);
        }

        $normalizedBoundStoreIds = $this->boundScopedStoreIds();

        if ($normalizedBoundStoreIds->isNotEmpty()) {
            return $normalizedBoundStoreIds;
        }

        $user = auth()->user();

        if (! $user instanceof User) {
            return collect();
        }

        if ($user->hasAnyRole(['super-admin', 'Consultant'])) {
            if ($user->current_store_id !== null) {
                return collect([(int) $user->current_store_id]);
            }

            return Store::query()->pluck('id')
                ->map(static fn ($id): int => (int) $id)
                ->values();
        }

        $assignedStoreIds = $user->stores()
            ->pluck('stores.id')
            ->map(static fn ($id): int => (int) $id)
            ->values();

        if ($user->current_store_id !== null) {
            return $assignedStoreIds->contains($user->current_store_id)
                ? collect([(int) $user->current_store_id])
                : collect();
        }

        if ((bool) resolve('multipleStoresExist')) {
            return $assignedStoreIds;
        }

        return Store::query()->pluck('id')
            ->map(static fn ($id): int => (int) $id)
            ->values();
    }

    /**
     * @return Collection<int, int>
     */
    protected function boundScopedStoreIds(): Collection
    {
        if (! app()->bound('scopedStoreIds')) {
            return collect();
        }

        /** @var Collection<int, int|string> $boundStoreIds */
        $boundStoreIds = resolve('scopedStoreIds');

        return $boundStoreIds
            ->map(static fn ($id): int => (int) $id)
            ->filter(static fn (int $id): bool => $id > 0)
            ->unique()
            ->values();
    }
}
