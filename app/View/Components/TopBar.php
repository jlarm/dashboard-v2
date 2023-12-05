<?php

namespace App\View\Components;

use App\Models\Dealer\Store;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TopBar extends Component
{
    public mixed $storeName;

    public function __construct()
    {
        $this->storeName = session('stores');
    }

    public function render(): View
    {
        return view('components.top-bar');
    }
}
