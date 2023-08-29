<?php

namespace App\Http\Livewire\Dealer\General;

use App\Models\Dealer\Store;
use Livewire\Component;

class MultiStoreLogo extends Component
{
    public Store $store;

    public function render()
    {
        return view('livewire.dealer.general.multi-store-logo', [
            'logo' => $this->store->logo ?? '',
        ]);
    }
}
