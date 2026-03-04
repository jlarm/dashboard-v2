<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class Note extends Component
{
    public ?string $note = null;
    public Store $store;

    public function mount(): void
    {
        if (app()->bound('currentStoreModel') && app('currentStoreModel') instanceof Store) {
            $this->store = app('currentStoreModel');
        } else {
            $currentStoreId = app('currentStore');

            if ($currentStoreId === null && app()->bound('accessibleStoreIds')) {
                $accessibleStoreIds = app('accessibleStoreIds');

                if ($accessibleStoreIds instanceof Collection && $accessibleStoreIds->count() === 1) {
                    $currentStoreId = (int) $accessibleStoreIds->first();
                }
            }

            $this->store = Store::query()->whereKey($currentStoreId)->firstOrFail();
        }

        $this->note = $this->store->note;
    }

    public function update(): void
    {
        $validated = $this->validate([
            'note' => ['nullable', 'string', 'max:65535'],
        ]);

        $this->store->update($validated);

        Notification::make()
            ->title('Note Updated Successfully!')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.dealer.home.note');
    }
}
