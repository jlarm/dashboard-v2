<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\General;

use App\Models\Dealer\Store;
use Livewire\Component;

class MultiStoreLogo extends Component
{
    public Store $store;
    public $logo;

    public function mount(): void
    {
        $this->logo = $this->store->getFirstMediaUrl('logo');
    }

    public function render()
    {
        return view('livewire.dealer.general.multi-store-logo');
    }
}
