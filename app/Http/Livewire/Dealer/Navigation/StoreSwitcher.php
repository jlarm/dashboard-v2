<?php

namespace App\Http\Livewire\Dealer\Navigation;

use App\Models\Dealer\Store;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Livewire\Component;

class StoreSwitcher extends Component
{
    public Store $store;

    public $currentStore;

    public $storeSlug;

    protected $listeners = ['refreshStores' => 'mount'];

    public function mount(Request $request): void
    {
        $this->setStoreSlug();
        $this->currentStore = $request->get('store')?->name;
    }

    public function render(): View
    {
        return view('livewire.dealer.navigation.store-switcher', [
            'stores' => $this->getStores(),
        ]);
    }

    private function setStoreSlug(): void
    {
        $this->storeSlug = request()->segment(2);
    }

    private function getStores()
    {
        if (auth()->user()->hasAnyRole(['super-admin', 'Consultant'])) {
            return Store::orderBy('name')->get();
        }
        return auth()->user()->stores;
    }
}
