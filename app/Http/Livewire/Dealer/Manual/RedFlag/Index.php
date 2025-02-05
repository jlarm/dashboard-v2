<?php

namespace App\Http\Livewire\Dealer\Manual\RedFlag;

use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Store;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public $store;

    protected $listeners = ['$refresh'];

    public function mount(Request $request): void
    {
        $this->store = $this->getStoreIdFromRequest($request);
    }

    private function getStoreIdFromRequest(Request $request): Store
    {
        $storeName = $request->get('store')?->name;

        if ($storeName) {
            return Store::where('name', $storeName)->select('id', 'slug')->first();
        }

        return Store::first()->select('id')->first();
    }

    public function render(): View
    {
        return view('livewire.dealer.manual.red-flag.index', [
            'manuals' => RedFlag::where('store_id', $this->store->id)->latest()->get(),
        ])->layout('components.dealer-app');
    }
}
