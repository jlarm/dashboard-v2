<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Vendor\Actions;

use App\Models\Dealer\Vendor;

class DeleteVendor
{
    public function handle(Vendor $vendor): void
    {
        $vendor->delete();
    }
}
