<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class CentralUserInviteRegisterRepository
{
    public function create(array $userData): void
    {
        $user = User::query()->create([
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
