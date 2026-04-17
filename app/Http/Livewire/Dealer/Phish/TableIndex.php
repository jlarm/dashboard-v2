<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Phish;

use App\Models\Dealer\PhishingCampaign;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TableIndex extends Component
{
    public function render(): Factory|View
    {
        return view('livewire.dealer.phish.table-index', [
            'campaigns' => PhishingCampaign::query()->latest()->get(),
        ]);
    }
}
