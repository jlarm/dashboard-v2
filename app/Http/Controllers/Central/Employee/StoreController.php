<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserInviteRequest;
use App\Repositories\CentralUserInviteRepository;

class StoreController extends Controller
{
    public function __invoke(StoreUserInviteRequest $request, CentralUserInviteRepository $repository)
    {
        $repository->create($request->validated());

        session()->flash('flash.type', 'success');
        session()->flash('flash.title', 'Employee Invited');
        session()->flash('flash.message', 'Employee has been successfully invited.');

        return redirect()->route('employees.index');
    }
}
