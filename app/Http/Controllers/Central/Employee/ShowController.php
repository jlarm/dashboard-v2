<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central\Employee;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ShowController extends Controller
{
    public function __invoke(User $user): Factory|View
    {
        return view('central.employee.view', ['user' => $user]);
    }
}
