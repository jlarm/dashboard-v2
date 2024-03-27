<?php

namespace App\Http\Livewire\Dealer\Phish;

use App\Models\Dealer\PhishingCampaign;
use Livewire\Component;

class TableIndex extends Component
{
    public function render()
    {
        return view('livewire.dealer.phish.table-index', [
            'campaigns' => PhishingCampaign::latest()->get(),
        ]);
    }
}
