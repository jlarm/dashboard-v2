<?php

namespace App\Http\Livewire\Central\Employee;

use App\Models\Course;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class IndexItem extends Component
{
    public User $user;

    public int $totalCourses;

    public $completed;

    public function mount(): void
    {
        $this->totalCourses = $this->totalCourses();

        $this->completed = $this->completedCourseCount();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.central.employee.index-item');
    }

    private function totalCourses(): int
    {
        return Cache::store('redis')->remember('total_courses_'.$this->user->id, 3600, function () {
            return Course::count() - 1;
        });
    }

    private function completedCourseCount(): int
    {
        return Cache::store('redis')->remember('completed_courses_'.$this->user->id, 3600, function () {
            return DB::table('course_results')
                ->where('user_id', $this->user->id)
                ->whereBetween('created_at', [now()->subYear(), now()])
                ->latest()
                ->get()
                ->groupBy('course_id')
                ->map(fn ($item) => $item->firstWhere('passed', 1))
                ->count();
        });
    }
}
