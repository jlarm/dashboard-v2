<?php

namespace App\Http\Livewire\Central\Permission;

use Filament\Notifications\Notification;
use Spatie\Permission\Models\Permission;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $permission;
    protected $permissionTypes = ['create', 'edit', 'delete', 'view'];

    public function mount($permission)
    {
        $this->permission = $permission;
    }

    public function delete()
    {
        $getPermission = Permission::where('name', 'create-'.$this->permission)->first();
        $name = mb_substr($getPermission->name, mb_strpos($getPermission->name, '-') + 1);
        foreach ($this->permissionTypes as $permissionType) {
            $permission = Permission::where('name', $permissionType.'-'.lcfirst($name))->first();
            $permission->roles()->detach();
            $permission->delete();
        }

        Notification::make()
            ->title('Permission Successfully Deleted!')
            ->success()
            ->send();

        return redirect()->route('permission.index');
    }

    public function render()
    {
        return view('livewire.central.permission.delete');
    }
}
