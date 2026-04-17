<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Course;

use App\Models\Dealer\Course;
use App\Models\Dealer\Department;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Edit extends Component
{
    public Course $course;
    public $assignedDepartments;

    public function mount(): void
    {
        $this->assignedDepartments = $this->course->departments()->pluck('name')->toArray();
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.course.edit', [
            'departments' => Department::all(),
        ]);
    }
}
