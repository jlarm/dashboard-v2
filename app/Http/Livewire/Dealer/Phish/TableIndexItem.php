<?php

namespace App\Http\Livewire\Dealer\Phish;

use Livewire\Component;

class TableIndexItem extends Component
{
    public $campaign;

    public function render()
    {
        return view('livewire.dealer.phish.table-index-item');
    }
}
