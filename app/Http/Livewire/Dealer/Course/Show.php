<?php

namespace App\Http\Livewire\Dealer\Course;

use App\Models\Dealer\Course;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class Show extends Component
{
    public Course $course;
    public $slides;

    public function mount()
    {
        $this->slides = collect($this->course->slides);
    }

    public function quizLink()
    {
        return URL::temporarySignedRoute(
            'courses.quiz',
            now()->addMinutes(30),
            ['course' => $this->course->slug]
        );
    }

    public function render()
    {
        $quizLink = $this->quizLink();

        return view('livewire.dealer.course.show', compact('quizLink'));
    }
}
