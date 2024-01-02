<?php

namespace App\Http\Livewire\Central\Department;

use App\Models\Course;
use App\Models\Department;
use Filament\Notifications\Notification;
use Livewire\Component;

class Edit extends Component
{
    public Department $department;

    public $name;

    public $assignedCourses = [];

    public function mount()
    {
        $this->name = $this->department->name;
        $this->assignedCourses = $this->department->courses?->pluck('id')->toArray();
    }

    public function updateName()
    {
        $this->department->update([
            'name' => $this->name,
        ]);

        Notification::make()
            ->title('Successfully updated')
            ->success()
            ->send();
    }

    public function updateCourses(): void
    {
        $this->department->courses()->sync($this->assignedCourses);

        Notification::make()
            ->title('Successfully updated')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.central.department.edit', [
            'courses' => Course::orderBy('name')->select('id', 'name')->get(),
        ]);
    }
}
