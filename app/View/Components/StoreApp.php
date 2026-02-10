<?php

declare(strict_types=1);

namespace App\View\Components;

use App\Models\Dealer\Store;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class StoreApp extends Component
{
    public $name;

    public function __construct(public Store $store)
    {
        $this->name = Route::currentRouteAction();
    }

    public function render(): View
    {
        return view('components.store-app');
    }
}
