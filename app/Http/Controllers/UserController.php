<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function create(CreateUserRequest $request)
    {
        return view('central.employee.register', [
            'email' => $request['email'],
            'name' => $request['name'],
            'role' => $request['role'],
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => bcrypt($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        //        Invite::where('id', $request['id'])->delete();

        event(new Registered($user));

        $user->markEmailAsVerified();

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
