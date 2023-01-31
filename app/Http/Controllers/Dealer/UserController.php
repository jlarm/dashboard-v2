<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDealerUserRequest;
use App\Models\Dealer\Invite;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Request;

class UserController extends Controller
{
    public function show(Invite $invite)
    {
        return view('dealer.employee.register', [
            'invite' => $invite,
        ]);
    }

    public function store(CreateDealerUserRequest $request)
    {
        $request = $request->validated();

        // Create user
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'store_id' => $request['store'],
            'department_id' => $request['department'],
            'password' => bcrypt($request['password']),
        ]);

        $user->assignRole($request['role']);

        event(new Registered($user));

        $user->markEmailAsVerified();

        Invite::where('id', $request['id'])
            ->update([
                'registered_at' => now(),
            ]);

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
