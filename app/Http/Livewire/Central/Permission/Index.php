<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Permission;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Override;
use Spatie\Permission\Models\Permission;

class Index extends Component
{
    public $permissions;
    public $items;
    public $permission;

    #[Override]
    protected $listeners = ['permissionCreated' => 'render'];

    public function mount(): void
    {
        $this->permissions = Permission::query()
            ->selectRaw("SUBSTRING_INDEX(name, '-', -1) AS name")
            ->groupBy('name')
            ->get();

        foreach ($this->permissions as $this->permission) {
            $this->items[$this->permission->name] = Permission::query()
                ->where('name', 'LIKE', "%{$this->permission->name}%")
                ->get();
        }
    }

    public function render(): Factory|View
    {
        return view('livewire.central.permission.index');
    }
}
