<?php

namespace App\Http\Livewire\Central\CourseManagement;

use App\Models\Course;
use Livewire\Component;

class Edit extends Component
{
    public Course $course;
    public $name;
    public array $slides;
    public $questions;

    public function mount()
    {
        $this->name = $this->course->name;
        $this->slides = $this->course->slides;
    }

    protected $rules = [
        'name' => 'required',
        'slides' => 'required',
    ];

    public function update()
    {
        dd($this->validate());
    }

    public function render()
    {
        return view('livewire.central.course-management.edit');
    }
}
