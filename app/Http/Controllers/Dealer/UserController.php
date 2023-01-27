<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDealerUserRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Request;

class UserController extends Controller
{
    public function create(CreateDealerUserRequest $request)
    {
//        $request = $request->validated();

        return view('dealer.employee.register', [
            'email' => $request['email'],
            'name' => $request['name'],
            'store' => $request['store'],
            'department' => $request['department'],
            'role' => $request['role'],
        ]);
    }

    public function store(CreateDealerUserRequest $request)
    {

//        $request = $request->validated();

        // Create user
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'store' => $request['store'],
            'department' => $request['department'],
            'phone' => $request['phone'],
            'password' => bcrypt($request['password']),
        ]);

        $user->assignRole($request['role']);

        event(new Registered($user));

        $user->markEmailAsVerified();

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
