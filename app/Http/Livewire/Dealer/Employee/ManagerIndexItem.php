<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\User;
use Livewire\Component;

class ManagerIndexItem extends Component
{
    public User $user;

    public function render()
    {
        return view('livewire.dealer.employee.manager-index-item');
    }
}
