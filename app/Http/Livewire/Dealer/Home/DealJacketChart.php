<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class DealJacketChart extends Component
{
    public function render(): Factory|View
    {
        return view('livewire.dealer.home.deal-jacket-chart');
    }
}
