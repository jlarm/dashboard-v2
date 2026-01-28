<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store\SingleStore\Vendor;

use App\Models\Dealer\Store;
use Livewire\Component;

class Index extends Component
{
    public Store $store;

    public function render()
    {
        return view('livewire.dealer.store.single-store.vendor.index', [
            'vendors' => $this->store->vendors()->get(),
        ])->layout('components.dealer-app');
    }
}
