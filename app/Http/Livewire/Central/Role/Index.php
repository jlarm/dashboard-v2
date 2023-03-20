<?php

namespace App\Http\Livewire\Central\Role;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    public function render()
    {
        return view('livewire.central.role.index', [
            'roles' => Role::orderBy('name', 'asc')
                ->whereNotIn('name', ['super-admin'])
                ->get()
        ]);
    }
}
