<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Navigation;

use App\Http\Livewire\Concerns\HandlesStoreSwitchRedirect;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Redirector as LivewireRedirector;

/**
 * @property-read Collection<int, Store> $stores
 * @property-read bool $canUseOverview
 */
class StoreSwitcher extends Component
{
    use HandlesStoreSwitchRedirect;

    public ?int $currentStoreId = null;
    public ?string $currentStoreName = null;
    protected $listeners = ['refreshStores' => '$refresh'];

    public function mount(): void
    {
        $this->syncSelectedStore();
    }

    public function render(): View
    {
        return view('livewire.dealer.navigation.store-switcher');
    }

    public function getStoresProperty(): Collection
    {
        $user = auth()->user();

        if (! $user instanceof User) {
            return new Collection();
        }

        if ($user->hasAnyRole(['super-admin', 'Consultant'])) {
            return Store::query()
                ->orderBy('name')
                ->get();
        }

        return $user->stores()
            ->orderBy('name')
            ->get();
    }

    public function getCurrentStoreDisplayProperty(): string
    {
        if ($this->currentStoreId === null) {
            return 'Overview';
        }

        if ($this->currentStoreName === null || $this->currentStoreName === '') {
            return 'Select a Store';
        }

        return Str::limit($this->currentStoreName, 30);
    }

    public function getCanUseOverviewProperty(): bool
    {
        return $this->stores->count() > 1;
    }

    public function getShouldDisplayProperty(): bool
    {
        return $this->stores->count() > 1;
    }

    public function switchStore(int $storeId): RedirectResponse|LivewireRedirector|null
    {
        if ($this->currentStoreId === $storeId) {
            return null;
        }

        /** @var Store|null $store */
        $store = $this->stores->firstWhere('id', $storeId);

        abort_unless($store instanceof Store, 403);

        auth()->user()->update(['current_store_id' => $store->id]);

        $this->currentStoreId = $store->id;
        $this->currentStoreName = $store->name;

        return $this->redirectToReferrer(
            collapseAuditDetailRoutes: true,
            redirectGlobalSettingsRoutesToSettings: true
        );
    }

    public function switchToOverview(): RedirectResponse|LivewireRedirector|null
    {
        if ($this->currentStoreId === null) {
            return null;
        }

        if (! $this->canUseOverview) {
            return $this->redirectToReferrer();
        }

        auth()->user()->update(['current_store_id' => null]);

        $this->currentStoreId = null;
        $this->currentStoreName = null;

        return $this->redirectToReferrer(
            redirectScanRoutesToDashboard: true,
            redirectSettingsRoutesToGlobal: true
        );
    }

    private function syncSelectedStore(): void
    {
        $selectedStore = $this->stores->firstWhere('id', auth()->user()->current_store_id);

        if (! $selectedStore instanceof Store) {
            $this->currentStoreId = null;
            $this->currentStoreName = null;

            return;
        }

        $this->currentStoreId = $selectedStore->id;
        $this->currentStoreName = $selectedStore->name;
    }
}
