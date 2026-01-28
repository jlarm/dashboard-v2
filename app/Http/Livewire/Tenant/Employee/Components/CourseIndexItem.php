<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Employee\Components;

use App\Models\Dealer\Course;
use App\Models\User;
use App\Traits\HasCourseStatus;
use Illuminate\View\View;
use Livewire\Component;

class CourseIndexItem extends Component
{
    use HasCourseStatus;

    public User $user;
    public Course $course;

    public function render(): View
    {
        return view('livewire.tenant.employee.components.course-index-item');
    }
}
