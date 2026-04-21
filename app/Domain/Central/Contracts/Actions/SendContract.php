<?php

declare(strict_types=1);

namespace App\Domain\Central\Contracts\Actions;

use App\Models\Contract;
use App\Models\User;
use App\Notifications\ContractNotification;
use Illuminate\Support\Facades\Notification;

class SendContract
{
    public function __construct(
        private readonly AppendContractStatus $appendStatus,
    ) {}

    /**
     * @param  array<int, string>  $emails
     */
    public function handle(User $user, Contract $contract, array $emails): void
    {
        foreach ($emails as $email) {
            Notification::route('mail', $email)
                ->notify(new ContractNotification($contract));

            $this->appendStatus->handle($contract, $user->name ?? '', 'sent contract to '.$email, 2);
        }
    }
}
