<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Auth;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    public function create(CreateUserRequest $request)
    {
        $validated = $request->validated();

        return view('central.employee.register', [
            'email' => $validated['email'],
            'name' => $validated['name'],
            'role' => $validated['role'],
        ]);
    }

    public function store(StoreUserRequest $request)
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

        event(new Registered($user));

        $user->markEmailAsVerified();

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
