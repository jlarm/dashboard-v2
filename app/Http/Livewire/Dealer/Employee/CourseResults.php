<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Department;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class CourseResults extends Component
{
    use WithPagination;

    public User $user;

    protected $listeners = ['refreshEmployeeDetails' => '$refresh'];

    public function render()
    {
        return view('livewire.dealer.employee.course-results', [
            'courses' => Department::where('id', $this->user->department_id)->with('courses')->first()->courses()->with([
                'results' => function ($query) {
                    $query->where('user_id', $this->user->id)->latest();
                },
            ])->orderBy('name')->paginate(24),
        ]);
    }
}
