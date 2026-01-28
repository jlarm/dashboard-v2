<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Store;
use Livewire\Component;

class StoreListItem extends Component
{
    public Store $store;

    public function render()
    {
        return view('livewire.dealer.home.store-list-item');
    }
}
