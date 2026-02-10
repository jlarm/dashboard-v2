<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\CourseManagement;

use App\Models\Course;
use App\Models\Dealership;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Livewire\Component;

class Edit extends Component implements HasForms
{
    use InteractsWithForms;

    public Course $course;
    public $name;
    public array $slides;
    public $questions;
    protected $rules = [
        'name' => 'required',
        'slides' => 'required',
    ];

    public function mount(): void
    {
        $this->name = $this->course->name;
        $this->slides = $this->course->slides;
    }

    public function update(): void
    {
        // Update central course
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
            ->title('Course updated')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.central.course-management.edit');
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')->required(),
            Repeater::make('slides')
                ->schema([
                    TextInput::make('title'),
                    RichEditor::make('description'),
                ])
                ->disableItemMovement()
                ->createItemButtonLabel('Add Slide'),
        ];
    }
}
