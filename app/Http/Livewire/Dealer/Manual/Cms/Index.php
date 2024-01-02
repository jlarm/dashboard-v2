<?php

namespace App\Http\Livewire\Dealer\Manual\Cms;

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
            return Store::where('name', $storeName)->select('id', 'slug')->first();
        }

        return Store::first()->select('id')->first();
    }

    public function render()
    {
        return view('livewire.dealer.manual.cms.index', [
            'manuals' => $this->store->cmsManuals()->get(),
        ])->layout('components.dealer-app');
    }
}
