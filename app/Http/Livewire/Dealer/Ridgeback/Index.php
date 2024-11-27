<?php

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
        $this->store = Store::where('id', app('currentStore'))->firstOrFail();

        if($this->checkIfRidgeBackExists()) {
            $this->ipAddress = $this->store->ridgeback()->firstOrFail()->ip_address;
            $this->active = $this->store->ridgeback()->firstOrFail()->active;
        }
    }

    public function checkIfRidgeBackExists(): bool
    {
        if ($this->store->ridgeback()->first()) {
            return true;
        }

        return false;
    }

    public function checkIfActive(): bool
    {
        if ($this->active) {
            return true;
        }

        return false;
    }

    public function checkHasIpAddress(): bool
    {
        if ($this->ipAddress) {
            return true;
        }

        return false;
    }

    public function render(): View
    {
        return view('livewire.dealer.ridgeback.index')
            ->layout('components.dealer-app');
    }
}
