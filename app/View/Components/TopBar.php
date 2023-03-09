<?php

namespace App\View\Components;

use App\Models\Dealer\Store;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TopBar extends Component
{
    public Store $store;

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    public function render(): View
    {
        return view('components.top-bar');
    }
}
