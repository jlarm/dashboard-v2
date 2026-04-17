<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Providers\AppServiceProvider;
use App\Repositories\CentralUserInviteRegisterRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class StoreRegistrationController extends Controller
{
    public function __invoke(StoreUserRequest $request, CentralUserInviteRegisterRepository $repository): Redirector|RedirectResponse
    {
        $repository->create($request->validated());

        return redirect(AppServiceProvider::HOME);
    }
}
