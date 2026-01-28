<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store\SingleStore\Manual;

use App\Models\Dealer\Store;
use Livewire\Component;

class RedFlag extends Component
{
    public Store $store;

    public function render()
    {
        return view('livewire.dealer.store.single-store.manual.red-flag')->layout('components.dealer-app');
    }
}
