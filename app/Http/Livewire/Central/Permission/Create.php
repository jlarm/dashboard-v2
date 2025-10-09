<?php

namespace App\Http\Livewire\Central\Permission;

use Filament\Notifications\Notification;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Create extends Component
{
    public $name;
    protected $permissionTypes = ['create', 'edit', 'delete', 'view'];
    protected $rules = [
        'name' => 'required|unique:permissions,name',
    ];

    public function create()
    {
        $this->validate();

        // remove "s" at end of name string if exists
        if (str_ends_with($this->name, 's')) {
            $this->name = mb_substr($this->name, 0, -1);
        }

        foreach ($this->permissionTypes as $permissionType) {
            Permission::create([
                'name' => $permissionType.'-'.lcfirst($this->name).'s',
                'guard_name' => 'web',
            ]);
        }

        $this->reset();

        //        $this->emit('permissionCreated');

        Notification::make()
            ->title('Permission Successfully Created!')
            ->success()
            ->send();

        return redirect()->route('permission.index');
    }

    public function render()
    {
        return view('livewire.central.permission.create');
    }
}
