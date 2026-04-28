<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Actions;

use App\Jobs\SendCustomEmployeeMessageJob;
use App\Models\User;
use Illuminate\Support\Collection;

class SendCustomEmployeeMessage
{
    /**
     * @param  Collection<int, User>  $users
     */
    public function handle(Collection $users, string $subject, string $messageBody): int
    {
        $sent = 0;

        foreach ($users as $user) {
            if ($user->email === null) {
                continue;
            }
            if ($user->email === '') {
                continue;
            }
            dispatch(new SendCustomEmployeeMessageJob($user, $subject, $messageBody));
            $sent++;
        }

        return $sent;
    }
}
