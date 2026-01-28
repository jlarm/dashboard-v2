<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store\SingleStore\Scan;

use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class IndexList extends Component
{
    public Store $store;

    public function render(): View
    {
        return view('livewire.dealer.store.single-store.scan.index-list');
    }
}
