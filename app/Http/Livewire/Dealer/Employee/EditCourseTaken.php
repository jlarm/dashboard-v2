<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Course;
use App\Models\Dealer\CourseResults;
use App\Models\User;
use Filament\Notifications\Notification;
use WireElements\Pro\Components\Modal\Modal;

class EditCourseTaken extends Modal
{
    public $course;
    public $user;
    public $dateTaken;

    public function mount(Course $course, User $user): void
    {
        $this->course = $course;
        $this->user = $user;
    }

    public function create(): void
    {
        CourseResults::query()->create([
            'percentage' => 100,
            'passed' => 1,
            'course_id' => $this->course->id,
            'user_id' => $this->user->id,
            'created_at' => $this->dateTaken,
        ]);

        $this->dispatch('refreshEmployeeDetails');

        $this->close();

        Notification::make()
            ->title('Employee Course Successfully Updated!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.dealer.employee.edit-course-taken');
    }
}
