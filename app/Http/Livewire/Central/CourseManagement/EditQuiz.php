<?php

namespace App\Http\Livewire\Central\CourseManagement;

use App\Models\Course;
use Livewire\Component;

class EditQuiz extends Component
{
    public Course $course;
    public $name;
    public $questions;
    public $answers = [];

    public function mount()
    {
        $this->name = $this->course->name;
        $this->questions = $this->course->questions;
    }

    public function addAnswer()
    {
        $this->answers[] = '';
    }
    public function render()
    {
        return view('livewire.central.course-management.edit-quiz');
    }
}
