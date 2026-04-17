<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\General;

use App\Models\Dealer\Store;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class StoreLogo extends Component
{
    public $logo;

    public function mount(): void
    {
        $this->logo = Store::query()->first()->getFirstMediaUrl('logo');
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.general.store-logo');
    }
}
