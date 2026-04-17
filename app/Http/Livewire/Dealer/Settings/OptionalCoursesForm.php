<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Settings;

use App\Models\Dealer\Course;
use Illuminate\View\View;
use Livewire\Component;

class OptionalCoursesForm extends Component
{
    public $courses;
    public $selectedCourses = [];

    public function mount(): void
    {
        $this->courses = Course::query()
            ->orderBy('name')
            ->get();
        $this->selectedCourses = $this->courses
            ->where('optional', true)
            ->pluck('id')
            ->mapWithKeys(fn ($id): array => [$id => true])
            ->all();
    }

    public function updatedSelectedCourses($value, $key): void
    {
        // toggle optional course
        $course = Course::query()->find($key);
        $course->optional = $value;
        $course->save();
    }

    public function render(): View
    {
        return view('livewire.dealer.settings.optional-courses-form');
    }
}
