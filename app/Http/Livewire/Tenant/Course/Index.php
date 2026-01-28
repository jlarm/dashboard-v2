<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Course;

use App\Queries\Feeds\CoursesFeed;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public function render(): View
    {
        $user = auth()->user();

        $courses = (new CoursesFeed($user))
            ->builder()
            ->orderby('name')
            ->get();

        return view('livewire.tenant.course.index', [
            'courses' => $courses,
        ])
            ->layout('components.dealer-app');
    }
}
