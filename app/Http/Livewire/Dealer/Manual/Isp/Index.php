<?php

namespace App\Http\Livewire\Dealer\Manual\Isp;

use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Store;
use Illuminate\Http\Request;
use Livewire\Component;

class Index extends Component
{
    public $store;

    public function mount(Request $request)
    {
        $this->store = $this->getStoreIdFromRequest($request);
    }

    private function getStoreIdFromRequest(Request $request)
    {
        $storeName = $request->get('store')?->name;

        if ($storeName) {
            return Store::where('name', $storeName)->select('id','slug')->first();
        }

        return Store::first()->select('id')->first();
    }

    public function render()
    {
        return view('livewire.dealer.manual.isp.index', [
            'manuals' => Isp::where('store_id', $this->store->id)->latest()->get(),
        ])->layout('components.dealer-app');
    }
}
