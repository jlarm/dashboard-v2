<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Permission;

use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class IndexItem extends Component
{
    public Permission $permission;
    public bool $enableEditing;

    public function mount(): void
    {
        Str::startsWith($this->permission->name, 'create') ? $this->enableEditing = true : $this->enableEditing = false;
    }

    public function render()
    {
        return view('livewire.central.permission.index-item');
    }
}
