<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Navigation;

use App\Models\Dealer\Store;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;

class StoreSwitcher extends Component
{
    public ?string $currentStoreName = null;

    protected $listeners = ['refreshStores' => '$refresh'];

    public function mount(Request $request): void
    {
        $this->currentStoreName = $request->get('store')?->name;
    }

    public function render(): View
    {
        return view('livewire.dealer.navigation.store-switcher');
    }

    public function getStoresProperty(): Collection
    {
        $user = auth()->user();

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
        if (!$this->currentStoreName) {
            return 'Select a Store';
        }

        return Str::limit($this->currentStoreName, 30);
    }
}
