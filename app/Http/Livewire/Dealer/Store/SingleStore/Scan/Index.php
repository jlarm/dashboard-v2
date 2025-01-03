<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Scan;

use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public Store $store;

    public function render(): View
    {
        return view('livewire.dealer.store.single-store.scan.index')->layout('components.dealer-app');
    }
}
