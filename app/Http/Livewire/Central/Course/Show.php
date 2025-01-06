<?php

namespace App\Http\Livewire\Central\Course;

use App\Models\Course;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Livewire\Component;

class Show extends Component
{
    public Course $course;

    public $slides;

    public function mount(): void
    {
        $this->slides = $this->course->slides;
    }

    public function quizLink(): string
    {
        return URL::temporarySignedRoute(
            'courses.quiz',
            now()->addMinutes(30),
            ['course' => $this->course->slug]
        );
    }

    public function render(): View
    {
        $quizLink = $this->quizLink();

        return view('livewire.central.course.show', compact('quizLink'));
    }
}
