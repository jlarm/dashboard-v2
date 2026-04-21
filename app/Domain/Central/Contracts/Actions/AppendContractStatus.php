<?php

declare(strict_types=1);

namespace App\Domain\Central\Contracts\Actions;

use App\Models\Contract;
use App\Models\ContractStatus;

class AppendContractStatus
{
    public function handle(Contract $contract, string $name, string $status, ?int $step = null): ContractStatus
    {
        return $contract->status()->create([
            'name' => $name,
            'status' => $status,
            'step' => $step,
        ]);
    }
}
