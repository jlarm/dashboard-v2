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
use Filament\Schemas\Schema;
use Illuminate\View\View;
use Livewire\Component;
use Throwable;

/**
 * @property-read Schema $form
 */
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
        $state = $this->form->getState();

        try {
            $this->course->update($state);

            tenancy()->central(function () use ($state): void {
                foreach (Dealership::all(['id']) as $tenant) {
                    /** @var Dealership $tenant */
                    tenancy()->initialize($tenant);

                    if ($tenantCourse = Course::query()->where('slug', $this->course->slug)->first()) {
                        $tenantCourse->update($state);
                    }
                }

                tenancy()->end();
            });

            Notification::make()
                ->title('Course quiz updated')
                ->success()
                ->send();

            $this->dispatch('course-quiz-updated', status: 'success', message: 'Course quiz updated.');
        } catch (Throwable $exception) {
            report($exception);

            Notification::make()
                ->title('Unable to update course quiz')
                ->danger()
                ->send();

            $this->dispatch('course-quiz-updated', status: 'error', message: 'Unable to update course quiz.');
        }
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
                        ->reorderable(false),
                    TextInput::make('correctAnswer'),
                ])
                ->reorderable(false)
                ->addActionLabel('Add Question'),
        ];
    }
}
