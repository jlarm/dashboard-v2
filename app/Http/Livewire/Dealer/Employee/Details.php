<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\User;
use Livewire\Component;

class Details extends Component
{
    public User $user;

    protected $listeners = ['refreshEmployeeDetails' => '$refresh'];

    public function render()
    {
        return view('livewire.dealer.employee.details');
    }
}
