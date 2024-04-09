<?php

namespace App\Http\Controllers\Central\Employee;

use App\Http\Controllers\Controller;

class CreateController extends Controller
{
    public function __invoke()
    {
        return view('central.employee.create');
    }
}
