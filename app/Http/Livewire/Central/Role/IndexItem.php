<?php

namespace App\Http\Livewire\Central\Role;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class IndexItem extends Component
{
    public Role $role;

    public function render()
    {
        return view('livewire.central.role.index-item');
    }
}
