<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Navigation;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ManagerStores extends Component
{
    public function render(): Factory|View
    {
        return view('livewire.dealer.navigation.manager-stores', [
            'stores' => auth()->user()->stores,
        ]);
    }
}
