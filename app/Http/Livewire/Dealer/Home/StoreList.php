<?php

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Store;
use Livewire\Component;
use Livewire\WithPagination;

class StoreList extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = ['refreshStores' => '$refresh'];
    public function render()
    {
        return view('livewire.dealer.home.store-list', [
            'stores' => Store::query()
                ->search('name', $this->search)
                ->paginate(10)
        ]);
    }
}
