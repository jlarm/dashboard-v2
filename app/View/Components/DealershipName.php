<?php

namespace App\View\Components;

use App\Models\Dealer\Store;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DealershipName extends Component
{
    public function render(): View
    {
        return view('components.dealership-name', [
            'current_store_name' => session('stores'),
        ]);
    }
}
