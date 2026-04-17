<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Department;

use App\Models\Department;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Override;

class Index extends Component
{
    #[Override]
    protected $listeners = ['departmentCreated' => 'render'];

    public function render(): Factory|View
    {
        return view('livewire.central.department.index', [
            'departments' => Department::query()->orderBy('name')->get(),
        ]);
    }
}
