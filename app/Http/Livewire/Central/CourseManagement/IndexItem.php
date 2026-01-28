<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\CourseManagement;

use App\Models\Course;
use Livewire\Component;

class IndexItem extends Component
{
    public Course $course;

    public function render()
    {
        return view('livewire.central.course-management.index-item');
    }
}
