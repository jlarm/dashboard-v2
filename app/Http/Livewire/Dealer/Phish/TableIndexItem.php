<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Phish;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TableIndexItem extends Component
{
    public $campaign;

    public function render(): Factory|View
    {
        return view('livewire.dealer.phish.table-index-item');
    }
}
