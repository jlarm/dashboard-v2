<?php

namespace App\Http\Livewire\Central\Employee;

use App\Models\Course;
use App\Models\User;
use DB;
use Livewire\Component;

class IndexItem extends Component
{
    public User $user;
    public int $totalCourses;
    public $completed;

    public function mount()
    {
        $this->totalCourses = Course::count();

        $this->completed = DB::table('course_results')
            ->where('user_id', $this->user->id)
            ->where('created_at', '>=', now()->subYear())
            ->latest()
            ->get()
            ->groupBy('course_id')
            ->map(function ($item) {
                return $item->first();
            });

        $this->completed = collect($this->completed->where('passed', 1))->count();
    }

    public function render()
    {
        return view('livewire.central.employee.index-item');
    }
}
