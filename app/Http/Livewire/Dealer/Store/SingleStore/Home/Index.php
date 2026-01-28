<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store\SingleStore\Home;

use App\Models\Dealer\Store;
use Livewire\Component;

class Index extends Component
{
    public Store $store;

    public function mount(): void
    {
        auth()->user()->update([
            'current_store_id' => $this->store->id,
        ]);
    }

    public function render()
    {
        return view('livewire.dealer.store.single-store.home.index')->layout('components.dealer-app');
    }
}
