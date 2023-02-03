<?php

namespace App\Http\Livewire\Dealer\Course;

use App\Models\Dealer\Course;
use Livewire\Component;

class Quiz extends Component
{
    public Course $course;
    public function render()
    {
        return view('livewire.dealer.course.quiz');
    }
}
