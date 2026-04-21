<?php

declare(strict_types=1);

namespace App\Domain\Central\Contracts\Actions;

use App\Models\Contract;

class DeleteContract
{
    public function handle(Contract $contract): void
    {
        $contract->delete();
    }
}
