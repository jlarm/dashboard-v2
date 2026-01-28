<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Course;

use App\Models\Course;
use Livewire\Component;

class Quiz extends Component
{
    public Course $course;

    public function render()
    {
        return view('livewire.central.course.quiz');
    }
}
