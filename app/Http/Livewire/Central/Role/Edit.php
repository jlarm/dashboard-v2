<?php

namespace App\Http\Livewire\Central\Role;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    public Role $role;
    public $name;
    public $assignedPermissions;

    public function mount()
    {
        $this->name = $this->role->name;
        $this->assignedPermissions = $this->role->permissions->pluck('name')->toArray();
    }

    public function update()
    {
        $this->role->name = $this->name;
        $this->role->save();
        $this->role->syncPermissions($this->assignedPermissions);

        return redirect()->route('role.index');
    }
    public function render()
    {
        return view('livewire.central.role.edit', [
            'permissions' => Permission::all()
        ]);
    }
}
