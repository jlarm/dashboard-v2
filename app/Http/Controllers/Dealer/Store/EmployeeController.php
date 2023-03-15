<?php

namespace App\Http\Controllers\Dealer\Store;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;
use App\Models\User;

class EmployeeController extends Controller
{
    public function index(Store $store)
    {
        return view('dealer.store.multi.employee-index', compact('store'));
    }

    public function show(Store $store, User $user)
    {
        return view('dealer.store.multi.employee-show', compact('store', 'user'));
    }
}
