<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Employee;

use App\Models\Dealer\Store;
use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public Store $store;
    public User $user;
    public function render()
    {
        return view('livewire.dealer.store.single-store.employee.show')->layout('components.dealer-app');
    }
}
