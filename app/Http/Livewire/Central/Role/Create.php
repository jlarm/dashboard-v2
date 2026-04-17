<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Role;

use Filament\Notifications\Notification;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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

    public function create(): void
    {
        $this->validate();

        $role = Role::create(['name' => $this->name]);
        $role->syncPermissions($this->assignedPermissions);

        $this->dispatch('roleCreated');

        $this->reset(['name', 'assignedPermissions']);

        Notification::make()
            ->title('Role Successfully Created!')
            ->success()
            ->send();
    }

    public function render(): Factory|View
    {
        return view('livewire.central.role.create', [
            'permissions' => Permission::all(),
        ]);
    }
}
