<?php

namespace App\Http\Livewire\Dealer\General;

use App\Models\Dealer\Store;
use Livewire\Component;

class StoreLogo extends Component
{
    public $logo;

    public function mount()
    {
        $this->logo = Store::first()->getFirstMediaUrl('logo');
    }

    public function render()
    {
        return view('livewire.dealer.general.store-logo');
    }
}
