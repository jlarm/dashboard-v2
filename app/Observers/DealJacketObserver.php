<?php

declare(strict_types=1);

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Dealer\Audit\DealJacket;

class DealJacketObserver
{
    public function creating(DealJacket $dealJacket): void
    {
        $dealJacket->uuid = (string) Str::uuid();
    }
}
