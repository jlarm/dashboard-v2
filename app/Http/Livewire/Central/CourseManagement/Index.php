<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\CourseManagement;

use App\Models\Course;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['coursesImported' => '$refresh'];

    public function render(): View
    {
        return view('livewire.central.course-management.index', [
            'courses' => Course::query()->orderBy('name')->get(),
        ]);
    }
}
