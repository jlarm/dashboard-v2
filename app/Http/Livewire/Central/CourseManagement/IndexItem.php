<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\CourseManagement;

use App\Models\Course;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public Course $course;

    public function render(): Factory|View
    {
        return view('livewire.central.course-management.index-item');
    }
}
