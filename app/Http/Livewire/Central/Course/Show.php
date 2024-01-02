<?php

namespace App\Http\Livewire\Central\Course;

use App\Models\Course;
use Livewire\Component;

class Show extends Component
{
    public Course $course;

    public function render()
    {
        return view('livewire.central.course.show');
    }
}
