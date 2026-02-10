<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Notifications\UserInviteNotification;
use Illuminate\Support\Facades\Notification;

class CentralUserInviteRepository
{
    public function create(array $userData)
    {
        Notification::route('mail', $userData['email'])
            ->notify(new UserInviteNotification($userData));

        return view('central.employee.index');
    }
}
