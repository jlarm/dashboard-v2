<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Permission;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Edit extends Component
{
    public Permission $permission;

    public function render(): Factory|View
    {
        return view('livewire.central.permission.edit');
    }
}
