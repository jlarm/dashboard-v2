<?php

namespace App\Repositories;

use App\Models\User;
use Auth;
use Illuminate\Auth\Events\Registered;

class CentralUserInviteRegisterRepository
{
    public function create($userData): void
    {
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'phone' => $userData['phone'],
            'password' => bcrypt($userData['password']),
        ]);

        $user->assignRole($userData['role']);

        event(new Registered($user));

        $user->markEmailAsVerified();

        Auth::login($user);
    }
}
