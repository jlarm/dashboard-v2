<?php

namespace App\Http\Controllers\Dealer\Store;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;

class EmployeeController extends Controller
{
    public function index(Store $store)
    {
        return view('dealer.store.multi.employee-index', compact('store'));
    }
}
