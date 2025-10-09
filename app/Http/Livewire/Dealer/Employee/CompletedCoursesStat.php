<?php

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

    public function percentage(): int
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
        $cacheKey = 'user_counts_'.$this->formattedName.'_'.($this->store?->id ?? 'all');

        return Cache::remember($cacheKey, now()->addHour(), function () {
            return [
                'total' => $this->getTotalUserCount(),
                'incomplete' => $this->getIncompleteCount(),
            ];
        });
    }

    protected function getTotalUserCount(): int
    {
        $query = $this->buildBaseQuery();

        return $query->count();
    }

    protected function getIncompleteCount(): int
    {
        return $this->users()
            ->filter(fn ($user) => $user->user_has_not_completed_courses)
            ->count();
    }

    protected function users()
    {
        $query = $this->buildBaseQuery();

        return $query->with(['results' => function ($query) {
            $query->select('id', 'user_id', 'course_id', 'passed', 'created_at')
                ->whereNull('deleted_at');
        }, 'roles:id'])->get();
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
