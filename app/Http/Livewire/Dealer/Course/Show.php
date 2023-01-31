<?php

namespace App\Http\Livewire\Dealer\Course;

use App\Models\Dealer\Course;
use Livewire\Component;

class Show extends Component
{
    public Course $course;
    public function render()
    {
        return view('livewire.dealer.course.show');
    }
}
