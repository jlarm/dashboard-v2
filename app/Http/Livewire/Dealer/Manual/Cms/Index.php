<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Manual\Cms;

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

    public function render(): View
    {
        return view('livewire.dealer.manual.cms.index', [
            'manuals' => $this->store->cmsManuals()->get(),
        ])->layout('components.dealer-app');
    }

    private function getStoreIdFromRequest(Request $request): Store
    {
        $storeName = $request->get('store')?->name;

        if ($storeName) {
            return Store::where('name', $storeName)->select('id', 'slug')->first();
        }

        return Store::first()->select('id')->first();
    }
}
