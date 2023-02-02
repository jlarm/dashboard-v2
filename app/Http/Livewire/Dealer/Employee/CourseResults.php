<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Course;
use App\Models\User;
use Livewire\Component;

class CourseResults extends Component
{
    public User $user;

    protected $listeners = ['refreshEmployeeDetails' => '$refresh'];
    public function render()
    {
        return view('livewire.dealer.employee.course-results', [
            'courses' => Course::query()
                ->where('department_id', $this->user->department_id)
                ->select('id', 'name')
                ->with('results', function ($query) {
                    $query->where('user_id', $this->user->id)->latest();
                })
                ->get()
        ]);
    }
}
