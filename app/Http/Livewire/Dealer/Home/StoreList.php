<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Store;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class StoreList extends Component
{
    use WithPagination;

    public string $search = '';
    protected $listeners = ['refreshStores' => '$refresh'];

    public function render(): View
    {
        return view('livewire.dealer.home.store-list', [
            'stores' => $this->stores(),
        ]);
    }

    protected function query()
    {
        if (auth()->user()->hasAnyRole(['super-admin', 'Consultant'])) {
            return Store::query();
        }

        return auth()->user()->stores();
    }

    private function stores()
    {
        $userId = auth()->id();
        $page = request('page', 1);
        $search = $this->search;

        $cacheKey = "store_list_user_{$userId}_page_{$page}_search_".md5($search);

        $cacheTime = 300;

        return Cache::remember($cacheKey, $cacheTime, function () use ($search) {
            $query = $this->query();

            if ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            }

            return $query
                ->with([
                    'individualAudits' => fn ($q) => $q->select('id', 'store_id', 'rating')->whereNotNull('rating'),
                    'financeAudits' => fn ($q) => $q->select('id', 'store_id', 'rating')->whereNotNull('rating'),
                    'oshaAudits' => fn ($q) => $q->select('id', 'store_id', 'rating')->whereNotNull('rating'),
                    'bodyShopAudits' => fn ($q) => $q->select('id', 'store_id', 'rating')->whereNotNull('rating'),
                ])
                ->select('id', 'name', 'slug')
                ->paginate(10);
        });
    }
}
