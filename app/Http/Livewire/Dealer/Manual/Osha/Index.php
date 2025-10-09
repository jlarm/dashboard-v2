<?php

namespace App\Http\Livewire\Dealer\Manual\Osha;

use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Store;
use Illuminate\Http\Request;
use Livewire\Component;

class Index extends Component
{
    public $store;
    protected $listeners = ['$refresh'];

    public function mount(Request $request)
    {
        $this->store = $this->getStoreIdFromRequest($request);
    }

    public function render()
    {
        return view('livewire.dealer.manual.osha.index', [
            'manuals' => Osha::where('store_id', $this->store->id)->latest()->get(),
        ])->layout('components.dealer-app');
    }

    private function getStoreIdFromRequest(Request $request)
    {
        $storeName = $request->get('store')?->name;

        if ($storeName) {
            return Store::where('name', $storeName)->select('id', 'slug')->first();
            }

            return Store::first()->select('id')->first();
        }
}
