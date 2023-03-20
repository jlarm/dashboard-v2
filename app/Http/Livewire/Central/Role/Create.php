<?php

namespace App\Http\Livewire\Central\Role;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    public $name;
    public $assignedPermissions = [];

    protected $rules = [
        'name' => 'required|string|max:255|unique:roles,name',
        'assignedPermissions' => 'required|array',
    ];

    public function create()
    {
        $validated = $this->validate();
//        ray($validated);

        $role = Role::create(['name' => $this->name]);
        $role->syncPermissions($this->assignedPermissions);

        return redirect()->route('role.index');
    }
    public function render()
    {
        return view('livewire.central.role.create', [
            'permissions' => Permission::all()
        ]);
    }
}
