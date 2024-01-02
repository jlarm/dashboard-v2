<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Docs;

use App\Models\Dealer\Store;
use Livewire\Component;

class Index extends Component
{
    public Store $store;

    protected $listeners = ['saved' => '$refresh'];

    public function render()
    {
        return view('livewire.dealer.store.single-store.docs.index', [
            'docs' => $this->store->docs,
        ])->layout('components.dealer-app');
    }
}
