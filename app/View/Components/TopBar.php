<?php

declare(strict_types=1);

namespace App\View\Components;

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
