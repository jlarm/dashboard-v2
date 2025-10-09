<?php

namespace App\View\Components;

use App\Models\Dealer\Store;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class StoreApp extends Component
{
    public Store $store;
    public $name;

    public function __construct(Store $store)
    {
        $this->name = Route::currentRouteAction();
        $this->store = $store;
    }

    public function render(): View
    {
        return view('components.store-app');
    }
}
