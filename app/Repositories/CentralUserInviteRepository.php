<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Support\Facades\Notification;
use App\Notifications\UserInviteNotification;

class CentralUserInviteRepository
{
    public function create(array $userData)
    {
        Notification::route('mail', $userData['email'])
            ->notify(new UserInviteNotification($userData));

        return view('central.employee.index');
    }
}
