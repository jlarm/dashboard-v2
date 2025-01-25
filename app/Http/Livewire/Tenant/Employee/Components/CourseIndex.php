<?php

namespace App\Http\Livewire\Tenant\Employee\Components;

use App\Models\User;
use App\Queries\Feeds\CoursesFeed;
use Illuminate\View\View;
use Livewire\Component;

class CourseIndex extends Component
{
    public User $user;

    public function render(): View
    {
        $courses = (new CoursesFeed($this->user))
            ->builder()
            ->orderBy('name')
            ->get();

        return view('livewire.tenant.employee.components.course-index', [
            'courses' => $courses,
        ]);
    }
}
