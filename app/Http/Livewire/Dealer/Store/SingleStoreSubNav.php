<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class SingleStoreSubNav extends Component
{
    public Store $store;

    public function render(): Factory|View
    {
        return view('livewire.dealer.store.single-store-sub-nav', [
            'stores' => Store::query()->orderBy('name')
                ->whereNot('id', $this->store->id)->get(),
            'storeCount' => Store::query()->count(),
        ]);
    }
}
