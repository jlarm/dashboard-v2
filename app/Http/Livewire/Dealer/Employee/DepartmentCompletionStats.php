<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
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

    public function loadStats(): void
    {
        $this->readyToLoad = true;
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

        // Filter by department if specified
        if ($departmentId !== null) {
            $query->where('department_id', $departmentId);
        }

        // Filter out role ID 5
        $query->whereHas('roles', function ($q) {
            $q->where('id', '!=', 5);
        });

        // Get total user count efficiently
        $totalUsers = $query->count();

        if ($totalUsers === 0) {
            return [
                'name' => $name,
                'total' => 0,
                'incomplete' => 0,
                'percentage' => 0,
            ];
        }

        // Calculate completed users using a database subquery
        $completedUsers = $this->countCompletedUsers($query, $departmentId);

        $incompleteUsers = $totalUsers - $completedUsers;
        $percentage = $totalUsers === 0 ? 0 : round(($completedUsers / $totalUsers) * 100);

        return [
            'name' => $name,
            'total' => $totalUsers,
            'incomplete' => $incompleteUsers,
            'percentage' => $percentage,
        ];
    }

    protected function countCompletedUsers($query, ?int $departmentId): int
    {
        $completedQuery = clone $query;

        $completedCount = 0;

        $completedQuery->select('id', 'department_id')
            ->with([
                'roles:id',
                'results' => function ($q) {
                    $q->select('id', 'user_id', 'course_id', 'passed', 'created_at')
                        ->where('passed', 1)
                        ->where(function ($query) {
                            $query->where('created_at', '>=', now()->subYear())
                                ->orWhere(function ($query) {
                                    $query->whereIn('course_id', [9, 10, 11, 12])
                                        ->where('created_at', '>=', now()->subYears(3));
                                });
                        })
                        ->whereNull('deleted_at');
                },
            ])
            ->chunk(50, function ($users) use (&$completedCount) {
                foreach ($users as $user) {
                    if (! $user->user_has_not_completed_courses) {
                        $completedCount++;
                    }
                }
            });

        return $completedCount;
    }

    protected function buildBaseQuery()
    {
        $query = null;

        // If a specific store is selected
        if ($this->store !== null) {
            $query = User::query()
                ->whereHas('stores', function ($q) {
                    $q->where('stores.id', $this->store->id);
                });
        } elseif (auth()->user()->hasAnyRole(['super-admin', 'Consultant'])) {
            // If the user is a super-admin or consultant
            $query = User::query();
        } elseif (! tenant('locations')) {
            $query = User::query();
        } else {
            // If the user is not a super-admin or consultant
            $currentUser = auth()->user();
            $query = User::query()
                ->whereHas('stores', function ($q) use ($currentUser) {
                    $q->whereIn('stores.id', $currentUser->stores->pluck('id'));
                });
        }

        return $query->whereNotIn('name', ['Joe Lohr', 'Terry Dortch', 'Mike Backer']);
    }

    protected function getCacheKey(): string
    {
        $userId = auth()->id();
        $storeId = $this->store?->id ?? 'all';
        $isSuperAdmin = auth()->user()->hasAnyRole(['super-admin', 'Consultant']) ? 'admin' : 'user';

        return "department_completion_stats_{$userId}_{$storeId}_{$isSuperAdmin}";
    }
}
