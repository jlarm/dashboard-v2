<?php

namespace App\Http\Livewire\Central\Employee;

use App\Models\Dealership;
use App\Models\User;
use Livewire\Component;

class DealershipList extends Component
{
    public User $user;
    public function render()
    {
        return view('livewire.central.employee.dealership-list', [
            'dealerships' => Dealership::where('user_id', $this->user->id)->get(),
        ]);
    }
}
