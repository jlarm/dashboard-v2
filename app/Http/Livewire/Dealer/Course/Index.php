<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Course;

use App\Traits\EmployeeCourses;
use Livewire\Component;

class Index extends Component
{
    use EmployeeCourses;

    public function mount(): void
    {
        $this->loadCurrentUser();
        $this->loadCoursesForCurrentUser();
    }

    public function render()
    {
        return view('livewire.dealer.course.index', [
            'courses' => $this->courses,
        ]);
    }
}
