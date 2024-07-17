<?php

namespace App\Http\Livewire\Central\Employee;

use WireElements\Pro\Components\SlideOver\SlideOver;

class Edit extends SlideOver
{
    public $name;

    public $email;

    public $phone;

    public $role;


    public function render()
    {
        return view('livewire.central.employee.edit');
    }
}
