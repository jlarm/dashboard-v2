<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Override;

class Details extends Component
{
    public Store $store;

    #[Override]
    protected $listeners = ['refreshStoreDetails' => '$refresh'];

    public function render(): Factory|View
    {
        return view('livewire.dealer.store.details');
    }
}
