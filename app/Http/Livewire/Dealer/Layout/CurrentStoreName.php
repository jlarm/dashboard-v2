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
        if($request->get('store')) {
            $this->storeName = $request->get('store')?->name;
        } elseif (auth()->user()->role('Manager') && count(auth()->user()->stores) === 1) {
            $this->storeName = auth()->user()->stores->first()->name;
        } else {
            $this->storeName = tenant('name');
        }
    }

    public function render()
    {
        return view('livewire.dealer.layout.current-store-name', [
            'storeName' => $this->storeName,
        ]);
    }
}
