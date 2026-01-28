<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Models\CmsManual;
use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class Manuals extends Component
{
    public ?Store $store;

    public function mount(): void
    {
        $this->store = $this->store ?? Store::first();
    }

    public function render(): View
    {
        return view('livewire.dealer.home.manuals', [
            'isp' => $this->hasManual('isps', Isp::class),
            'osha' => $this->hasManual('oshas', Osha::class),
            'redFlag' => $this->hasManual('redFlags', RedFlag::class),
            'cms' => $this->hasManual('cmsManuals', CmsManual::class),
        ]);
    }

    private function hasManual(string $relation, string $modelClass): bool
    {
        return $this->store
            ? $this->store->{$relation}->count() > 0
            : $modelClass::exists();
    }
}
