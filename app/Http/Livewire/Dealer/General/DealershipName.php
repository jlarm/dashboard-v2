<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\General;

use App\Models\Dealer\Store;
use App\Models\Dealer\StoreSettings;
use Livewire\Component;

class DealershipName extends Component
{
    public Store $store;
    public string $logo;

    public function mount(): void
    {
        $this->logo = StoreSettings::query()->first()->logo;
    }

    public function render()
    {
        return view('livewire.dealer.general.dealership-name');
    }
}
