<?php

namespace App\Http\Livewire\Central\Role;

use App\Models\Course;
use App\Models\Role;
use Filament\Notifications\Notification;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Edit extends Component
{
    public Role $role;
    public $name;
    public $assignedPermissions = [];
    public $assignedCourses = [];

    public function mount()
    {
        $this->name = $this->role->name;
        $this->assignedPermissions = $this->role->permissions->pluck('name')->toArray();
        $this->assignedCourses = $this->role->courses->pluck('id')->toArray();
    }

    public function updateRole(): void
    {
        $this->role->name = $this->name;
        $this->role->save();

        Notification::make()
            ->title('Role Updated Successfully!')
            ->success()
            ->send();
    }

    public function updatePermissions(): void
    {
        $this->role->syncPermissions($this->assignedPermissions);

        Notification::make()
            ->title('Permissions Successfully Updated!')
            ->success()
            ->send();
    }

    public function updateCourses(): void
    {
        $this->role->courses()->detach();
        $this->role->courses()->attach($this->assignedCourses, ['model_type' => Course::class]);

        Notification::make()
            ->title('Courses Successfully Updated!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.central.role.edit', [
            'permissions' => Permission::all(),
            'courses' => Course::orderBy('name')->select('id', 'name')->get(),
        ]);
    }
}
