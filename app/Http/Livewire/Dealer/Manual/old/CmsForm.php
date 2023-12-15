<?php

namespace App\Http\Livewire\Dealer\Manual\old;

use App\Models\Dealer\Store;
use App\Models\User;
use Livewire\Component;

class CmsForm extends Component
{
    public function render()
    {
        return view('livewire.dealer.manual.cms-form', [
            'standard_dpp_rate' => Store::first()->standard_dpp_rate,
            'qi' => User::role('Qualified Individual')->first() ?? null,
        ])->layout('components.dealer-app');
    }
}
