<?php

namespace App\Http\Livewire\Dealer\Layout;

use Illuminate\Http\Request;
use Livewire\Component;

class CurrentStoreName extends Component
{
    public $storeName;
    public $storeSlug;

    public function mount(Request $request): void
    {
        $this->storeName = $request->get('store')?->name ?? tenant('name');
    }

    public function render()
    {
        return view('livewire.dealer.layout.current-store-name', [
            'storeName' => $this->storeName,
        ]);
    }
}
