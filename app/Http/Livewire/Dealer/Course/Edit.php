<?php

namespace App\Http\Livewire\Dealer\Course;

use App\Models\Dealer\Course;
use App\Models\Dealer\Department;
use Livewire\Component;

class Edit extends Component
{
    public Course $course;
    public $assignedDepartments;

    public function mount()
    {
        $this->assignedDepartments = $this->course->departments()->pluck('name')->toArray();
    }

    public function render()
    {
        return view('livewire.dealer.course.edit', [
            'departments' => Department::all(),
        ]);
    }
}
