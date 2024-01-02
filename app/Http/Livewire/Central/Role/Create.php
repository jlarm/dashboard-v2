<?php

namespace App\Http\Livewire\Central\Role;

use Filament\Notifications\Notification;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    public $name;

    public $assignedPermissions = [];

    protected $rules = [
        'name' => 'required|string|max:255|unique:roles,name',
        'assignedPermissions' => 'nullable|array',
    ];

    public function create()
    {
        $validated = $this->validate();

        $role = Role::create(['name' => $this->name]);
        $role->syncPermissions($this->assignedPermissions);

        $this->emit('roleCreated');

        $this->reset(['name', 'assignedPermissions']);

        Notification::make()
            ->title('Role Successfully Created!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.central.role.create', [
            'permissions' => Permission::all(),
        ]);
    }
}
