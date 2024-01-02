<?php

namespace App\Http\Controllers\Dealer\Manual;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;
use Illuminate\View\View;

class OshaController extends Controller
{
    public function __invoke(): View
    {
        $store = Store::first();

        return view('dealer.manual.osha', compact('store'));
    }
}
