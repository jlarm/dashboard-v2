<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Location;

use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class EditStoreModal extends Modal
{
    public int $storeId;
    public Store $storeModel;
    public string $name = '';
    public string $address = '';
    public string $city = '';
    public string $state = '';
    public string $postal_code = '';
    public string $phone = '';
    public string $website = '';
    protected array $rules = [
        'name' => 'required|max:255',
        'address' => 'required|max:255',
        'city' => 'required|max:255',
        'state' => 'required|max:255',
        'postal_code' => 'required|max:255',
        'phone' => 'required|max:255',
        'website' => 'required|max:255',
    ];

    public function mount(): void
    {
        $this->storeModel = Store::query()->findOrFail($this->storeId);
        $this->name = (string) $this->storeModel->name;
        $this->address = (string) $this->storeModel->address;
        $this->city = (string) $this->storeModel->city;
        $this->state = (string) $this->storeModel->state;
        $this->postal_code = (string) $this->storeModel->postal_code;
        $this->phone = (string) $this->storeModel->phone;
        $this->website = (string) $this->storeModel->website;
    }

    public function updateStore(): void
    {
        $this->validate();

        $this->storeModel->update([
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
            'phone' => $this->phone,
            'website' => $this->website,
        ]);

        $this->emit('refreshLocations');

        $this->close();

        Notification::make()
            ->title('Location updated successfully.')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.tenant.location.edit-store-modal');
    }
}
