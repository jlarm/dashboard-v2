<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;

class EmployeeIndexController extends Controller
{

    public function __invoke()
    {
        return view('dealer.employee.index', [
            'stores' => Store::count()
        ]);
    }
}
