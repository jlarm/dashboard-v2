<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Course;
use App\Models\User;
use Livewire\Component;

class AssignCustomCoursesForm extends Component
{
    public User $user;

    public $courses;

    public $selectedCourses = [];

    public function mount(): void
    {
        $userRoleIds = $this->user->roles->pluck('name')->toArray();

        $this->courses = Course::query()
            ->orderBy('name')
            ->whereHas('departments')
            ->whereDoesntHave('departments', function ($query) {
                $query->where('department_id', $this->user->department_id);
            })
            ->whereNotIn('name', $userRoleIds)
            ->orWhere('optional', true)
            ->select(['id', 'name'])
            ->get();

        // Initialize selectedCourses with user's current courses
        $this->selectedCourses = $this->user->courses->pluck('id')->flip()->map(fn () => true)->toArray();
    }

    public function updatedSelectedCourses($value, $key): void
    {
        if ($value) {
            $this->user->courses()->attach($key);
        } else {
            $this->user->courses()->detach($key);
        }

        $this->user->refresh();

        $this->emit('refreshEmployeeDetails');
    }

    public function render()
    {
        return view('livewire.dealer.employee.assign-custom-courses-form');
    }
}
