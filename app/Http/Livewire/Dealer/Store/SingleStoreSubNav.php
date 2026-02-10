<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use Livewire\Component;

class SingleStoreSubNav extends Component
{
    public Store $store;

    public function render()
    {
        return view('livewire.dealer.store.single-store-sub-nav', [
            'stores' => Store::query()->orderBy('name')
                ->whereNot('id', $this->store->id)->get(),
            'storeCount' => Store::query()->count(),
        ]);
    }
}
