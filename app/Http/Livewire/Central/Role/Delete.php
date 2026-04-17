<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Role;

use Spatie\Permission\Models\Role;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $role;

    public function mount(Role $role): void
    {
        $this->role = $role;
    }

    public function delete(): void
    {
        $this->role->delete();
        $this->dispatch('roleDeleted');
        $this->close();
    }

    public function render()
    {
        return view('livewire.central.role.delete');
    }
}
