<?php

declare(strict_types=1);

namespace App\Domain\Tenant\DealJackets\Actions;

use App\Models\Dealer\Audit\DealJacketGroup;

class CompleteDealJacketGroup
{
    public function handle(DealJacketGroup $group): void
    {
        $group->update(['completed' => true]);
    }
}
