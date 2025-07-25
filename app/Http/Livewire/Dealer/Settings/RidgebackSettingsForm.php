<?php

namespace App\Http\Livewire\Dealer\Settings;

use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Livewire\Component;

class RidgebackSettingsForm extends Component
{
    public Store $store;

    public string $ipAddress = '';

    public bool $active = false;

    public function mount(): void
    {
        $ridgeback = $this->store->ridgeback()->first() ?? null;

        if ($ridgeback) {
            $this->ipAddress = $ridgeback->ip_address;
            $this->active = $ridgeback->active;
        }
    }

    protected array $rules = [
        'ipAddress' => 'required|ip',
        'active' => 'nullable|boolean',
    ];

    public function update(): void
    {
        $this->validate();

        $this->store->ridgeback()->updateOrCreate(
            [],
            [
                'active' => $this->active,
                'ip_address' => $this->ipAddress,
            ]
        );

        Notification::make()
            ->title('Settings Updated Successfully!')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.dealer.settings.ridgeback-settings-form');
    }
}
