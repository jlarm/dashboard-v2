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
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        // Create user
        $user = User::create($validated);

        event(new Registered($user));

        $user->markEmailAsVerified();

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
