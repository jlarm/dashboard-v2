<?php

declare(strict_types=1);

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Dealer\Audit\DealJacketGroup;

class DealJacketGroupObserver
{
    public function creating(DealJacketGroup $dealJacketGroup): void
    {
        $dealJacketGroup->uuid = (string) Str::uuid();
    }
}
