<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Livewire\Component;

class CompletedCoursesStat extends Component
{
    public ?Store $store = null;
    public ?int $department = null;
    public string $name = '';
    public bool $readyToLoad = false;
    public string $formattedName;

    public function mount(): void
    {
        $this->formattedName = str_replace(' ', '', $this->name);
        $this->formattedName = str_replace('/', '', $this->formattedName);
    }

    public function loadStat(): void
    {
        $this->readyToLoad = true;
    }

    public function percentage(): float
    {
        $counts = $this->getUserCounts();

        if ($counts['total'] === 0) {
            return 0;
        }

        return round((($counts['total'] - $counts['incomplete']) / $counts['total']) * 100);
    }

    public function render(): View
    {
        $percentage = $this->readyToLoad ? $this->percentage() : '';

        return view('livewire.dealer.employee.completed-courses-stat', compact('percentage'));
    }

    protected function getUserCounts(): array
    {
        $cacheKey = $this->getCacheKey();

        return Cache::remember($cacheKey, 300, function () {
            return [
                'total' => $this->getTotalUserCount(),
                'incomplete' => $this->getIncompleteCount(),
            ];
        });
    }

    protected function getCacheKey(): string
    {
        $userId = auth()->id();
        $storeId = $this->store?->id ?? 'all';
        $department = $this->department ?? 'all';
        $isSuperAdmin = auth()->user()->hasAnyRole(['super-admin', 'Consultant']) ? 'admin' : 'user';

        return "completed_courses_stat_{$userId}_{$storeId}_{$department}_{$isSuperAdmin}";
    }

    protected function getTotalUserCount(): int
    {
        $query = $this->buildBaseQuery();

        return $query->count();
    }

    protected function getIncompleteCount(): int
    {
        $query = $this->buildBaseQuery();

        // Only select needed columns to reduce memory usage
        return $query->whereHas('roles', function ($q) {
            $q->where('id', '!=', 5);
        })->get(['id', 'department_id'])
            ->filter(function ($user) {
                // Load minimal data for the calculation
                $user->loadMissing(['roles:id', 'results:id,user_id,course_id,passed,created_at']);

                return $user->user_has_not_completed_courses;
            })
            ->count();
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

        return $query
            ->whereNotIn('name', ['Joe Lohr', 'Terry Dortch', 'Mike Backer'])
            ->when($this->department, function ($query) {
                $query->where('department_id', $this->department);
            });
    }
}
