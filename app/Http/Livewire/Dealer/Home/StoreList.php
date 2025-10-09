<?php

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class StoreList extends Component
{
    use WithPagination;

    public $search = '';
    protected $listeners = ['refreshStores' => '$refresh'];

    public function render(): View
    {
        return view('livewire.dealer.home.store-list', [
            'stores' => $this->query()
                ->with([
                    'individualAudits' => fn ($q) => $q->select('id', 'store_id', 'rating')->whereNotNull('rating'),
                    'financeAudits' => fn ($q) => $q->select('id', 'store_id', 'rating')->whereNotNull('rating'),
                    'oshaAudits' => fn ($q) => $q->select('id', 'store_id', 'rating')->whereNotNull('rating'),
                    'bodyShopAudits' => fn ($q) => $q->select('id', 'store_id', 'rating')->whereNotNull('rating'),
                ])
                ->select('id', 'name', 'slug')
                ->paginate(10),
        ]);
    }

    protected function query()
    {
        if (auth()->user()->hasAnyRole(['super-admin', 'Consultant'])) {
            return Store::query();
        }

        return auth()->user()->stores();
    }
}
