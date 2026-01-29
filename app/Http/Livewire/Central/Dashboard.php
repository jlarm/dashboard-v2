<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central;

use App\Models\Dealership;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class Dashboard extends Component
{
    public function render(): View
    {
        return view('livewire.central.dashboard', [
            'dealerships' => $this->dealerships(),
        ]);
    }

    private function dealerships(): Collection
    {
        if (auth()->user()->hasAnyRole('super-admin|Consultant')) {
            return Dealership::with('domains')->orderBy('name')->get();
        }

        return auth()->user()->dealerships->orderBy('name')->get();
    }
}
