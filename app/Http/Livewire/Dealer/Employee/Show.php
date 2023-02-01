<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public User $user;
    public function render()
    {
        return view('livewire.dealer.employee.show');
    }
}
