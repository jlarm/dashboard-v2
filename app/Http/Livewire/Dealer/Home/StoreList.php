<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Store;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Redirector as LivewireRedirector;
use Livewire\WithPagination;

class StoreList extends Component
{
    use WithPagination;

    public string $search = '';
    protected $listeners = ['refreshStores' => '$refresh'];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function selectStore(int $storeId): RedirectResponse|LivewireRedirector
    {
        /** @var Store|null $store */
        $store = $this->query()
            ->whereKey($storeId)
            ->first();

        abort_unless($store instanceof Store, 403);

        auth()->user()->update([
            'current_store_id' => $store->id,
        ]);

        return redirect()->route('dealer.dashboard');
    }

    public function render(): View
    {
        return view('livewire.dealer.home.store-list', [
            'stores' => $this->stores(),
        ]);
    }

    protected function query(): Builder|BelongsToMany
    {
        if (auth()->user()->hasAnyRole(['super-admin', 'Consultant'])) {
            return Store::query();
        }

        return auth()->user()->stores();
    }

    private function stores(): LengthAwarePaginator
    {
        $query = $this->query();

        if ($this->search !== '' && $this->search !== '0') {
            $query->where('name', 'LIKE', "%{$this->search}%");
        }

        return $query
            ->select(['id', 'name', 'slug'])
            ->paginate(10);
    }
}
