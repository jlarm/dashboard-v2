<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Employee;

use App\Models\User;
use Livewire\Component;

class Deleted extends Component
{
    public function render()
    {
        return view('livewire.central.employee.deleted', [
            'users' => User::query()->latest()->onlyTrashed()->get(),
        ]);
    }
}
