<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Manual\Isp;

use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Store;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Override;

class Index extends Component
{
    public ?Store $store = null;

    #[Override]
    protected $listeners = ['$refresh'];

    public function mount(): void
    {
        /** @var Store|null $currentStore */
        $currentStore = app()->bound('currentStoreModel') ? resolve('currentStoreModel') : null;
        $this->store = $currentStore;
    }

    public function render(): View
    {
        $storeIds = $this->resolveScopedStoreIds();

        return view('livewire.dealer.manual.isp.index', [
            'manuals' => $storeIds->isEmpty()
                ? collect()
                : Isp::query()->whereIn('store_id', $storeIds)->latest()->get(),
            'canCreateManual' => $this->store instanceof Store,
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
