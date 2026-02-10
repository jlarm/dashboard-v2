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
            if ($this->store !== null) {
                $storeIds[] = $this->store->id;
            } else {
                $storeIds = Store::pluck('id')->toArray();
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

        $query->whereHas('roles', function ($q) {
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
                'roles:id',
                'stores:id,state',
                'courseOverrides:user_id,course_id,type',
                'results' => function ($q) use ($oneYearAgo, $threeYearsAgo) {
                    $q->select('id', 'user_id', 'course_id', 'passed', 'created_at')
                        ->where('passed', 1)
                        ->where(function ($query) use ($oneYearAgo, $threeYearsAgo) {
                            $query->where('created_at', '>=', $oneYearAgo)
                                ->orWhere(function ($query) use ($threeYearsAgo) {
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

        if ($this->store !== null) {
            $query->whereHas('stores', function ($q) {
                $q->where('stores.id', $this->store->id);
            });
        } elseif (! auth()->user()->hasAnyRole(['super-admin', 'Consultant']) && tenant('locations')) {
            $currentUser = auth()->user();
            $query->whereHas('stores', function ($q) use ($currentUser) {
                $q->whereIn('stores.id', $currentUser->stores->pluck('id'));
            });
        }

        $excludedUsers = config('dashboard.excluded_users', []);

        if (! empty($excludedUsers)) {
            $query->whereNotIn('name', $excludedUsers);
        }

        return $query;
    }

    protected function getCacheKey(): string
    {
        $storeId = $this->store?->id ?? 'all';
        $tenantId = tenant('id') ?? 'no-tenant';

        if ($storeId !== 'all') {
            return "department_completion_stats_{$storeId}_{$tenantId}";
        }

        if (auth()->user()->hasAnyRole(['super-admin', 'Consultant'])) {
            return "department_completion_stats_all_{$tenantId}_admin";
        }

        $userStoreIds = auth()->user()->stores->pluck('id')->sort()->implode('_');

        return "department_completion_stats_all_{$tenantId}_user_{$userStoreIds}";
    }
}
