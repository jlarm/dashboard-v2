<?php

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.dealer.store.index', [
            'stores' => Store::latest()->paginate(10),
        ]);
    }
}
