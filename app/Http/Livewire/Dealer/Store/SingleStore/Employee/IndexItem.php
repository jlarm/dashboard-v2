<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Employee;

use App\Models\Dealer\Course;
use App\Models\Dealer\Department;
use App\Models\User;
use Livewire\Component;

class IndexItem extends Component
{
    public User $user;

    public $completed;

    public $totalCourses;
    public $departmentCourseCount;
    public $unassignedCourseCount;

    public function mount()
    {
        $this->user = User::find($this->user->id);

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
            $this->departmentCourseCount = Department::where('id', $this->user->department_id)->with('courses')->first()->courses()->count();
        }

        $this->unassignedCourseCount = Course::whereDoesntHave('departments')->count();

        $this->totalCourses = $this->departmentCourseCount + $this->unassignedCourseCount;

        if ($this->user->stores[0]->state != 'California') {
            $this->totalCourses = $this->totalCourses - 1;
        }
    }
    public function render()
    {
        return view('livewire.dealer.store.single-store.employee.index-item', [
            'department' => Department::where('id', $this->user->department_id)->first(),
        ]);
    }
}
