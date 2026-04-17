<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central\Employee;

use App\Providers\AppServiceProvider;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Providers\RouteServiceProvider;
use App\Repositories\CentralUserInviteRegisterRepository;

class StoreRegistrationController extends Controller
{
    public function __invoke(StoreUserRequest $request, CentralUserInviteRegisterRepository $repository)
    {
        $repository->create($request->validated());

        return redirect(AppServiceProvider::HOME);
    }
}
