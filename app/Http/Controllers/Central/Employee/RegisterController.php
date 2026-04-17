<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class RegisterController extends Controller
{
    public function __invoke(CreateUserRequest $request): Factory|View
    {
        return view('central.employee.register', [
            'email' => $request['email'],
            'name' => $request['name'],
            'role' => $request['role'],
        ]);
    }
}
