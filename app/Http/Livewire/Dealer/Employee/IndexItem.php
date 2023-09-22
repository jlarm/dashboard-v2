<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Course;
use App\Models\Dealer\Department;
use App\Models\Dealer\Store;
use App\Models\User;
use DB;
use Livewire\Component;

class IndexItem extends Component
{
    public User $user;

    public $completed;

    public $totalCourses;
    public $departmentCourseCount;
    public $unassignedCourseCount;
    public $courseWithRole;

    public function mount()
    {
        $this->user = User::find($this->user->id);

        $userRole = $this->user->roles()->select('id')->first()->toArray();
        $this->courseWithRole = DB::table('course_role')->where('role_id', $userRole)->pluck('course_id')->toArray();

        // Get all passed courses within the last year for this user
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

        // Get all courses for this user's department
        if ($this->user->department_id) {
            $this->departmentCourseCount = Course::with('results')
                ->WhereHas('departments', function ($query) {
                    $query->where('id', $this->user->department_id);
                })
                ->whereIn('id', $this->courseWithRole)
                ->orWhereDoesntHave('departments')->count();
        }

        $this->totalCourses = $this->departmentCourseCount;

        if (Store::exists() && Store::first()->pluck('state') != 'California') {
            $this->totalCourses = $this->totalCourses - 1;
        }

    }

    public function render()
    {
        return view('livewire.dealer.employee.index-item', [
            'department' => Department::where('id', $this->user->department_id)->first(),
        ]);
    }
}
