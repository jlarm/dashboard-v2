<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central\Employee;

use App\Http\Controllers\Controller;
use App\Models\User;

class ShowController extends Controller
{
    public function __invoke(User $user)
    {
        return view('central.employee.view', ['user' => $user]);
    }
}
