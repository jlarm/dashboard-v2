<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Docs;

use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public Store $store;

    protected $listeners = ['saved' => '$refresh'];

    public function render(): View
    {
        return view('livewire.dealer.store.single-store.docs.index', [
            'docs' => $this->store->docs,
        ])->layout('components.dealer-app');
    }
}
