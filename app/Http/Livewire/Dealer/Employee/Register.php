<?php

namespace App\Http\Livewire\Dealer\Employee;

use Livewire\Component;

class Register extends Component
{
    public $phone;
    public $password;

    public function store()
    {
        dd($this->phone, $this->password);
    }
    public function render()
    {
        return view('livewire.dealer.employee.register');
    }
}
