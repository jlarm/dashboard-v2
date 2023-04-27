<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\Osha;

use App\Models\Dealer\Store;
use Livewire\Component;

class Create extends Component
{
    public Store $store;
    public function render()
    {
        return view('livewire.dealer.store.single-store.audit.osha.create')->layout('components.dealer-app');
    }
}
