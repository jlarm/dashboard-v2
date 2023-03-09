<?php

namespace App\Http\Livewire\Dealer\Navigation;

use Livewire\Component;

class ManagerStores extends Component
{
    public function render()
    {
        return view('livewire.dealer.navigation.manager-stores', [
            'stores' => auth()->user()->stores,
        ]);
    }
}
