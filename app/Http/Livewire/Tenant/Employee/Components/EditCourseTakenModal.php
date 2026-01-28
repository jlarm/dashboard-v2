<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Employee\Components;

use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class EditCourseTakenModal extends Modal
{
    public int|User $user;
    public int|Course $course;
    public $dateTaken;
    protected $rules = [
        'dateTaken' => 'required|date',
    ];

    public function mount(User $user, Course $course): void
    {
        $this->user = $user;
        $this->course = $course;
    }

    public function create(): void
    {
        $this->validate();

        CourseResults::create([
            'percentage' => 100,
            'passed' => 1,
            'course_id' => $this->course->id,
            'user_id' => $this->user->id,
            'created_at' => $this->dateTaken,
        ]);

        $this->close();

        Notification::make()
            ->title('Employee Course Successfully Updated')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.tenant.employee.components.edit-course-taken-modal');
    }
}
