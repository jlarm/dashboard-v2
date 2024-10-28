<?php

namespace App\Http\Livewire\Dealer\Course;

use App\Traits\EmployeeCourses;
use Livewire\Component;

class Index extends Component
{
    use EmployeeCourses;

    public function render()
    {
        return view('livewire.dealer.course.index', [
            'courses' => $this->loadCoursesForCurrentUser(auth()->user())
        ]);
    }
}
