<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\CourseManagement;

use App\Models\Course;
use App\Models\Dealership;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Livewire\Component;

class EditQuiz extends Component implements HasForms
{
    use InteractsWithForms;

    public Course $course;
    public $name;
    public $questions;
    public $answers = [];

    public function mount(): void
    {
        $this->name = $this->course->name;
        $this->questions = $this->course->questions;
    }

    public function update(): void
    {
        $this->course->update($this->form->getState());

        // Update matching courses across all tenants
        tenancy()->central(function (): void {
            foreach (Dealership::all() as $tenant) {
                tenancy()->initialize($tenant);

                if ($tenantCourse = Course::query()->where('slug', $this->course->slug)->first()) {
                    $tenantCourse->update($this->form->getState());
                }
            }
        });

        Notification::make()
            ->title('Course quiz updated')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.central.course-management.edit-quiz');
    }

    protected function getFormSchema(): array
    {
        return [
            Repeater::make('questions')
                ->schema([
                    TextInput::make('question'),
                    Repeater::make('answers')
                        ->schema([
                            KeyValue::make(''),
                        ])
                        ->disableItemMovement(),
                    TextInput::make('correctAnswer'),
                ])
                ->disableItemMovement()
                ->createItemButtonLabel('Add Question'),
        ];
    }
}
