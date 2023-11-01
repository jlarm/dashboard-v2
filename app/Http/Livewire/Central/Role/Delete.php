<?php

namespace App\Http\Livewire\Central\Role;

use Spatie\Permission\Models\Role;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $role;

    public function mount(Role $role)
    {
        $this->role = $role;
    }

    public function delete()
    {
        $this->role->delete();
        $this->emit('roleDeleted');
        $this->close();
    }

    public function render()
    {
        return view('livewire.central.role.delete');
    }
}
