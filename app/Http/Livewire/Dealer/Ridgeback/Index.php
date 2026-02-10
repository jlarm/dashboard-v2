<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Ridgeback;

use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public Store $store;
    public string $ipAddress = '';
    public bool $active;

    public function mount(): void
    {
        $this->store = Store::query()->where('id', app('currentStore'))->firstOrFail();

        if ($this->checkIfRidgeBackExists()) {
            $this->ipAddress = $this->store->ridgeback()->firstOrFail()->ip_address;
            $this->active = $this->store->ridgeback()->firstOrFail()->active;
        }
    }

    public function checkIfRidgeBackExists(): bool
    {
        return (bool) $this->store->ridgeback()->first();
    }

    public function checkIfActive(): bool
    {
        return $this->active;
    }

    public function checkHasIpAddress(): bool
    {
        return (bool) $this->ipAddress;
    }

    public function render(): View
    {
        return view('livewire.dealer.ridgeback.index')
            ->layout('components.dealer-app');
    }
}
