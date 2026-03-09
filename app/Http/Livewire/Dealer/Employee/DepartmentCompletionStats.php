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

class DepartmentCompletionStats extends Component
{
    private const DEPARTMENTS = [
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
    protected $listeners = ['refreshEmployeeDetails' => 'clearCacheAndRefresh'];

    public function loadStats(): void
    {
        $this->readyToLoad = true;
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
        if ($this->readyToLoad) {
            $this->stats = $this->calculateAllStats();
        }

        return view('livewire.dealer.employee.department-completion-stats', [
            'departments' => self::DEPARTMENTS,
        ]);
    }

    protected function clearAllCachesForTenantAndStore(): void
    {
        $tenantId = tenant('id') ?? 'no-tenant';
        $storeIds = [];

        try {
            if ($this->store instanceof Store) {
                $storeIds[] = $this->store->id;
            } else {
                $storeIds = Store::query()->pluck('id')->toArray();
            }
        } catch (Exception $e) {
            Log::warning('Failed to fetch store IDs for cache clearing', [
                'error' => $e->getMessage(),
                'tenant_id' => $tenantId,
            ]);
            $storeIds = [];
        }

        foreach ($storeIds as $storeId) {
            Cache::forget("department_completion_stats_{$storeId}_{$tenantId}");
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

    protected function calculateAllStats(): array
    {
        $cacheKey = $this->getCacheKey();

        return Cache::remember($cacheKey, 300, function () {
            $stats = [];

            foreach (self::DEPARTMENTS as $key => $department) {
                $departmentId = $department['id'];
                $stats[$key] = $this->calculateDepartmentStat($departmentId, $department['name']);
            }

            return $stats;
        });
    }

    protected function calculateDepartmentStat(?int $departmentId, string $name): array
    {
        $query = $this->buildBaseQuery();

        if ($departmentId !== null) {
            $query->where('department_id', $departmentId);
        }

        $query->whereHas('roles', function ($q): void {
            $q->where('id', '!=', 5);
        });

        $userIds = $query->pluck('id');

        if ($userIds->isEmpty()) {
            return [
                'name' => $name,
                'total' => 0,
                'incomplete' => 0,
                'percentage' => 0,
            ];
        }

        $statsData = $this->getCompletionStats($userIds);

        $totalUsers = $statsData['total'];
        $completedUsers = $statsData['completed'];

        if ($totalUsers === 0) {
            return [
                'name' => $name,
                'total' => 0,
                'incomplete' => 0,
                'percentage' => 0,
            ];
        }

        $incompleteUsers = $totalUsers - $completedUsers;
        $percentage = round(($completedUsers / $totalUsers) * 100);

        return [
            'name' => $name,
            'total' => $totalUsers,
            'incomplete' => $incompleteUsers,
            'percentage' => $percentage,
        ];
    }

    protected function getCompletionStats(Collection $userIds): array
    {
        if ($userIds->isEmpty()) {
            return ['total' => 0, 'completed' => 0];
        }

        $oneYearAgo = now()->subYear();
        $threeYearsAgo = now()->subYears(3);

        $users = User::query()
            ->whereIn('id', $userIds)
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

        return ['total' => $totalCount, 'completed' => $completedCount];
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

        if ((bool) app('multipleStoresExist')) {
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
        $boundStoreIds = app('scopedStoreIds');

        return $boundStoreIds
            ->map(static fn ($id): int => (int) $id)
            ->filter(static fn (int $id): bool => $id > 0)
            ->unique()
            ->values();
    }
}
