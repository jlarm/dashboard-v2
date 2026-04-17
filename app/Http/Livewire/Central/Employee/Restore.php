<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Employee;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class Restore extends Model
{
    public function render(): Factory|View
    {
        return view('livewire.central.employee.restore');
    }
}
