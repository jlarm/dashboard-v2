<?php

namespace App\Http\Livewire\Dealer\Phish;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Create extends Component
{

    public function render()
    {
        return view('livewire.dealer.phish.create')->layout('components.dealer-app');
    }
}
