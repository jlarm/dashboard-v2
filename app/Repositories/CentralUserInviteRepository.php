<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Notifications\UserInviteNotification;
use Notification;

class CentralUserInviteRepository
{
    public function create($userData)
    {
        Notification::route('mail', $userData['email'])
            ->notify(new UserInviteNotification($userData));

        return view('central.employee.index');
    }
}
