<?php

declare(strict_types=1);

namespace App\Domain\Tenant\DealJackets\Actions;

use App\Models\Dealer\Audit\DealJacket;

class DeleteDealJacket
{
    public function handle(DealJacket $jacket): void
    {
        $jacket->delete();
    }
}
