<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Actions;

use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Invite;

class ResendInvite
{
    public function handle(Invite $invite): void
    {
        dispatch(new SendQueueEmailJob($invite));
        $invite->touch();
    }
}
