<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Course;
use App\Models\Dealer\Department;
use App\Models\Dealer\Store;
use App\Models\User;
use Livewire\Component;

class IndexItem extends Component
{
    public User $user;

    public $completed;

    public $totalCourses;
    public $departmentCourseCount;
    public $unassignedCourseCount;
    private $courses;
    private $userRole;
    private $courseWithRole;

    public function mount()
    {
        $this->userRole = $this->user->roles()->pluck('id')->toArray();

        $this->userRole = array_diff($this->userRole, [5]);

        $this->courseWithRole = \DB::table('course_role')->where('role_id', $this->userRole)->pluck('course_id')->toArray();

        $this->courses = Course::query()
            ->WhereHas('departments', function ($query) {
                $query->where('id', $this->user->department_id);
            })
            ->whereIn('id', $this->courseWithRole)
            ->orWhereDoesntHave('departments')
            ->get();

        $courseIds = $this->courses->pluck('id')->toArray();

        $this->completed = \DB::table('course_results')
            ->where('user_id', $this->user->id)
            ->whereIn('course_id', $courseIds)
            ->where('created_at', '>=', now()->subYear())
            ->latest()
            ->get()
            ->groupBy('course_id')
            ->map(function ($item) {
                return $item->first();
            });

        $this->completed = collect($this->completed->where('passed', 1))->count();

        $this->totalCourses = $this->courses->count();

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
