<?php

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use App\Models\User;
use Livewire\Component;

class Employees extends Component
{
    public Store $store;

    public function render()
    {
        return view('livewire.dealer.store.employees', [
            'users' => User::where('store_id', $this->store->id)
                ->with('roles')
                ->with('department')
                ->get(),
        ]);
    }
}
