<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use Override;

class Index extends Component
{
    use WithPagination;

    public ?Store $store = null;

    #[Override]
    protected $listeners = ['refreshVendors' => '$refresh'];

    public function mount(): void
    {
        $this->store ??= null;
    }

    public function render()
    {
        $scopedStoreIds = $this->resolveScopedStoreIds();

        return view('livewire.dealer.vendor.index', [
            'vendors' => Vendor::with(['store:id,name', 'latestForm'])
                ->where(function (Builder $query) use ($scopedStoreIds): void {
                    if ($scopedStoreIds->isNotEmpty()) {
                        $query->whereIn('store_id', $scopedStoreIds);
                    }

                    $query->orWhereNull('store_id');
                })
                ->orderBy('name')
                ->paginate(16),
        ])->layout('components.dealer-app');
    }

    private function resolveScopedStoreIds(): Collection
    {
        if (app()->bound('scopedStoreIds')) {
            /** @var Collection $storeIds */
            $storeIds = resolve('scopedStoreIds');

            $normalizedStoreIds = $storeIds->map(static fn ($id): int => (int) $id)->values();

            if ($normalizedStoreIds->isNotEmpty()) {
                return $normalizedStoreIds;
            }
        }

        if ($this->store instanceof Store) {
            return collect([$this->store->id]);
        }

        $user = auth()->user();

        if (! $user) {
            return collect();
        }

        if ($user->hasAnyRole(['super-admin', 'Consultant'])) {
            return $user->current_store_id !== null
                ? collect([(int) $user->current_store_id])
                : Store::query()->pluck('id');
        }

        $assignedStoreIds = $user->stores()->pluck('stores.id')->map(static fn ($id): int => (int) $id);

        if ($user->current_store_id === null) {
            return $assignedStoreIds;
        }

        if ($assignedStoreIds->contains($user->current_store_id)) {
            return collect([(int) $user->current_store_id]);
        }

        return collect();
    }
}
