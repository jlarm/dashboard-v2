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
    public $courseWithRole;

    public function mount()
    {
        $userRole = $this->user->roles()->select('id')->first()->toArray();
        $this->courseWithRole = \DB::table('course_role')->where('role_id', $userRole)->pluck('course_id')->toArray();
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
        if ($this->user->department_id) {
            $this->totalCourses =  Course::query()
                ->WhereHas('departments', function ($query) {
                    $query->where('id', $this->user->department_id);
                })
                ->whereIn('id', $this->courseWithRole)
                ->orWhereDoesntHave('departments')
                ->with([
                    'results' => function ($query) {
                        $query->where('user_id', $this->user->id)->latest();
                    }
                ])
                ->orderBy('name')
                ->count();
        }
    }

    public function render()
    {
        return view('livewire.dealer.employee.manager-index-item');
    }
}
