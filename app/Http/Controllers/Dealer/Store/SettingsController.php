<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer\Store;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function __invoke(): View
    {
        $store = Store::first();

        return view('dealer.store.settings', compact('store'));
    }
}
