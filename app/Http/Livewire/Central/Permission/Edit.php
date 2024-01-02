<?php

namespace App\Http\Livewire\Central\Permission;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Edit extends Component
{
    public Permission $permission;

    public function render()
    {
        return view('livewire.central.permission.edit');
    }
}
