<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Employee;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Deleted extends Component
{
    public function render(): Factory|View
    {
        return view('livewire.central.employee.deleted', [
            'users' => User::query()->latest()->onlyTrashed()->get(),
        ]);
    }
}
