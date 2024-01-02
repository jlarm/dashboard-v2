<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserInviteRequest;
use App\Models\User;
use App\Notifications\UserInviteNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Notification;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function index(): View
    {
        return view('central.employee.index', [
            'users' => User::latest()->get(),
        ]);
    }

    public function show(User $user): View
    {
        return view('central.employee.view', [
            'user' => $user,
        ]);
    }

    public function create(): View
    {
        return view('central.employee.create', [
            'roles' => Role::all(),
        ]);
    }

    public function send(StoreUserInviteRequest $request): RedirectResponse
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
