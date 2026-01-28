<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use Livewire\Component;

class StoreSelector extends Component
{
    public function render()
    {
        if (auth()->user()->can('create-stores')) {
            return view('livewire.dealer.store.store-selector', [
                'stores' => Store::orderBy('name')
                    ->skip(1)->get(),
            ]);
        }

        return view('livewire.dealer.store.store-selector', [
            'stores' => auth()->user()->stores,
        ]);

    }
}
