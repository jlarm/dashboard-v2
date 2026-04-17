<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Permission;

use Filament\Notifications\Notification;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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
        if (str_ends_with((string) $this->name, 's')) {
            $this->name = mb_substr((string) $this->name, 0, -1);
        }

        foreach ($this->permissionTypes as $permissionType) {
            Permission::create([
                'name' => $permissionType.'-'.lcfirst((string) $this->name).'s',
                'guard_name' => 'web',
            ]);
        }

        $this->reset();

        //        $this->dispatch('permissionCreated');

        Notification::make()
            ->title('Permission Successfully Created!')
            ->success()
            ->send();

        return to_route('permission.index');
    }

    public function render(): Factory|View
    {
        return view('livewire.central.permission.create');
    }
}
