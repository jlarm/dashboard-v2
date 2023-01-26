<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserInviteRequest;
use App\Models\User;
use App\Notifications\UserInviteNotification;
use Notification;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('central.employee.index', [
            'users' => User::latest()->get(),
        ]);
    }

    public function show(User $user)
    {
        return view('central.employee.view', [
            'user' => $user,
        ]);
    }

    public function create()
    {
        return view('central.employee.create', [
            'roles' => Role::all(),
        ]);
    }

    public function send(StoreUserInviteRequest $request)
    {
        $validated = $request->validated();

        $email = $validated['email'];
        $name = $validated['name'];
        $role = $validated['role'];

        Notification::route('mail', $email)
            ->notify(new UserInviteNotification($validated));

        return redirect()->route('employees.index');
    }
}
