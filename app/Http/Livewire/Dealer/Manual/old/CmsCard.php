<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Manual\old;

use App\Models\Dealer\Store;
use Livewire\Component;

class CmsCard extends Component
{
    public Store $store;

    public function render()
    {
        return view('livewire.dealer.manual.cms-card');
    }
}
