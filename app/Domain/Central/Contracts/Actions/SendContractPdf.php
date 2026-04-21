<?php

declare(strict_types=1);

namespace App\Domain\Central\Contracts\Actions;

use App\Models\Contract;
use App\Models\User;
use App\Notifications\ContractPdfNotification;
use Illuminate\Support\Facades\Notification;

class SendContractPdf
{
    public function __construct(
        private readonly AppendContractStatus $appendStatus,
    ) {}

    public function handle(User $user, Contract $contract, string $email): void
    {
        Notification::route('mail', $email)
            ->notify(new ContractPdfNotification($contract));

        $this->appendStatus->handle($contract, $user->name ?? '', 'sent contract pdf to '.$email, 5);
    }
}
