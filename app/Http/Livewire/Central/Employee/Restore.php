<?php

namespace App\Http\Livewire\Central\Employee;

use Illuminate\Database\Eloquent\Model;

class Restore extends Model
{
    public function render()
    {
        return view('livewire.central.employee.restore');
    }
}
