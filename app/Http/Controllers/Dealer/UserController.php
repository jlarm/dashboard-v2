<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Invite;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(User $user)
    {
        return view('dealer.employee.show', [
            'user' => $user,
        ]);
    }

    public function create(Invite $invite)
    {
        return view('dealer.employee.register', [
            'invite' => $invite,
        ]);
    }

    public function store(Request $request)
    {
        $invite = Invite::where('id', $request['id'])->first();

        $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        // Create user
        $user = User::create([
            'name' => $invite['name'],
            'email' => $invite['email'],
            'phone' => $request->input('phone'),
            'department_id' => $invite['department_id'],
            'password' => bcrypt($request->input('password')),
        ]);

        foreach ($invite['stores'] as $store) {
            $user->stores()->attach($store);
        }

        $user->assignRole($invite['roles']);

        $invite->delete();

        event(new Registered($user));

        $user->markEmailAsVerified();

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
