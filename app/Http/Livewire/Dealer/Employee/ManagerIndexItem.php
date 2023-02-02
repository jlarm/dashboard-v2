<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Course;
use App\Models\User;
use Livewire\Component;

class ManagerIndexItem extends Component
{
    public User $user;
    public $completed;
    public $totalCourses;
    public function mount()
    {
        // Get all passed courses within the last year for this user
        $this->completed = \DB::table('course_results')
            ->where('user_id', $this->user->id)
            ->where('created_at', '>=', now()->subYear())
            ->latest()
            ->get()
            ->groupBy('course_id')
            ->map(function ($item) {
                return $item->first();
            });

        $this->completed = collect($this->completed->where('passed', 1))->count();

        // Get all courses for this user's department
        $this->totalCourses = Course::where('department_id', $this->user->department_id)->count();
    }
    public function render()
    {
        return view('livewire.dealer.employee.manager-index-item');
    }
}
