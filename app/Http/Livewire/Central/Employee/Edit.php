<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Employee;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use WireElements\Pro\Components\SlideOver\SlideOver;

class Edit extends SlideOver
{
    public $name;
    public $email;
    public $phone;
    public $role;

    public function render(): Factory|View
    {
        return view('livewire.central.employee.edit');
    }
}
