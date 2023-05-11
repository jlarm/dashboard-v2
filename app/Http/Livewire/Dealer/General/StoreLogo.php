<?php

namespace App\Http\Livewire\Dealer\General;

use App\Models\Dealer\Store;
use Livewire\Component;

class StoreLogo extends Component
{
    public function render()
    {
        return view('livewire.dealer.general.store-logo', [
            'logo' => Store::first()->logo,
        ]);
    }
}
