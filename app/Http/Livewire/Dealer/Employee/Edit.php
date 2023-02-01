<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\User;
use WireElements\Pro\Components\SlideOver\SlideOver;

class Edit extends SlideOver
{
    public $user;
    public $name;
    public $role;
    public $store;
    public $department;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->role = $user->role;
        $this->store = $user->store;
        $this->department = $user->department;
    }

    public function render()
    {
        return view('livewire.dealer.employee.edit');
    }
}
