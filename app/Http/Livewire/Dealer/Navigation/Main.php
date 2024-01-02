<?php

namespace App\Http\Livewire\Dealer\Navigation;

use App\Models\Dealer\Store;
use Illuminate\Http\Request;
use Livewire\Component;

class Main extends Component
{
    public $currentStore;

    public function mount(Request $request): void
    {
        $this->currentStore = Store::where('name', $request->get('store')?->name)->first();
    }

    public function render()
    {
        return view('livewire.dealer.navigation.main');
    }
}
