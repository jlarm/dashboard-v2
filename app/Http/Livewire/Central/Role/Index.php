<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Role;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    protected $listeners = [
        'roleCreated' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.central.role.index', [
            'roles' => Role::query()->orderBy('name', 'asc')
                ->with('permissions')
                ->whereNotIn('name', ['super-admin'])
                ->get(),
        ]);
    }
}
