<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Dealer\Audit\DealJacketGroup;
use Illuminate\Support\Str;

class DealJacketGroupObserver
{
    public function creating(DealJacketGroup $dealJacketGroup): void
    {
        $dealJacketGroup->uuid = (string) Str::uuid();
    }
}
