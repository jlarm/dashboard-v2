<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\CourseManagement;

use App\Models\Course;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.central.course-management.index', [
            'courses' => Course::query()->orderBy('name')->get(),
        ]);
    }
}
