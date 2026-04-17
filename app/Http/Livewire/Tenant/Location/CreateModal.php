<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Location;

use App\Services\StoreCreator;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class CreateModal extends Modal
{
    public string $name = '';
    public string $address = '';
    public string $city = '';
    public string $state = '';
    public string $postal_code = '';
    public string $phone = '';
    public string $website = '';
    protected array $rules = [
        'name' => 'required|max:255|unique:stores,name|regex:/^[a-zA-Z0-9 ]+$/',
        'address' => 'required|max:255',
        'city' => 'required|max:255',
        'state' => 'required|max:255',
        'postal_code' => 'required|max:255',
        'phone' => 'required|max:255',
        'website' => 'required|max:255',
    ];

    public function mount(): void
    {
        abort_unless($this->canCreateLocation(), 403);
    }

    public function createStore(StoreCreator $storeCreator): void
    {
        abort_unless($this->canCreateLocation(), 403);

        $validated = $this->validate();
        $storeCreator->create($validated);

        $this->dispatch('refreshLocations');

        $this->close();

        Notification::make()
            ->title('Location created successfully.')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.tenant.location.create-modal');
    }

    private function canCreateLocation(): bool
    {
        return auth()->user()?->hasAnyRole('super-admin|Consultant') ?? false;
    }
}
