<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Course;

use App\Models\Course;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Quiz extends Component
{
    public Course $course;

    public function render(): Factory|View
    {
        return view('livewire.central.course.quiz');
    }
}
