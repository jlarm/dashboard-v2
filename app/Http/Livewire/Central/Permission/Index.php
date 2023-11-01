<?php

namespace App\Http\Livewire\Central\Permission;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Index extends Component
{
    public $permissions;
    public $items;
    public $permission;
    protected $listeners = ['permissionCreated' => 'render'];

    public function mount()
    {
        $this->permissions = Permission::query()
            ->selectRaw("SUBSTRING_INDEX(name, '-', -1) AS name")
            ->groupBy('name')
            ->get();

        foreach ($this->permissions as $this->permission) {
            $this->items[$this->permission->name] = Permission::query()
                ->where('name', 'LIKE', "%{$this->permission->name}%")
                ->get();
        }
    }
    public function render()
    {
        return view('livewire.central.permission.index');
    }
}
