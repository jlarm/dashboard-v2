<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class CompletedCoursesStat extends Component
{
    public ?Store $store = null;

    public ?int $department = null;

    public string $name = '';

    public $readyToLoad = false;

    public $formattedName;

    public function mount(): void
    {
        $this->formattedName = str_replace(' ', '', $this->name);
        $this->formattedName = str_replace('/', '', $this->formattedName);
    }

    public function loadStat(): void
    {
        $this->readyToLoad = true;
    }

    protected function users()
    {
        $query = User::query()->whereNotIn('name', ['Joe Lohr', 'Terry Dortch', 'Mike Backer']);

        if ($this->store !== null) {
            $query = $this->store->users()->whereNotIn('name', ['Joe Lohr', 'Terry Dortch', 'Mike Backer']);
        }

        if ($this->department !== null) {
            $query->where('department_id', $this->department);
        }

        return $query->get();
    }

    protected function incompleteCount()
    {
        return $this->users()
            ->filter(function ($user) {
                return $user->user_has_not_completed_courses;
            })
            ->count();
    }

    protected function userCount()
    {
        return $this->users()->count();
    }

    public function percentage()
    {
        $userCount = $this->userCount();
        if ($userCount == 0) {
            return 0;
        }

        $complete = $userCount - $this->incompleteCount();

        return round(($complete / $userCount) * 100);
    }

    public function render()
    {
        $percentage = Cache::remember('course_stat_'.$this->formattedName, now()->addDay(), function () {
            return $this->readyToLoad ? $this->percentage() : '';
        });

        return view('livewire.dealer.employee.completed-courses-stat', compact('percentage'));
    }
}
