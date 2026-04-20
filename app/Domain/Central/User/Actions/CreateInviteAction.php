<?php

declare(strict_types=1);

namespace App\Domain\Central\User\Actions;

use App\Domain\Central\User\Data\CreateInviteData;
use App\Models\Central\UserInvite;
use App\Notifications\Central\UserInviteNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class CreateInviteAction
{
    public function execute(CreateInviteData $data, int $inviterId): UserInvite
    {
        return DB::transaction(function () use ($data, $inviterId) {
            $invite = UserInvite::query()->create([
                'name' => $data->name,
                'email' => $data->email,
                'role' => UserInvite::CONSULTANT_ROLE,
                'invited_by' => $inviterId,
                'expires_at' => now()->addDays(7),
            ]);

            Notification::route('mail', $invite->email)
                ->notify(new UserInviteNotification($invite));

            return $invite;
        });
    }
}
