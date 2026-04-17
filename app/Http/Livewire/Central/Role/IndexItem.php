<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Role;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class IndexItem extends Component
{
    public Role $role;

    public function render(): Factory|View
    {
        return view('livewire.central.role.index-item');
    }
}
