<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Ridgeback;

use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public function render(): View
    {
        return view('livewire.dealer.ridgeback.index')
            ->layout('components.dealer-app');
    }
}
