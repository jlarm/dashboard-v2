<?php

namespace App\Observers;

use App\Models\Dealer\Audit\DealJacket;
use Str;

class DealJacketObserver
{
    public function creating(DealJacket $dealJacket): void
    {
        $dealJacket->uuid = (string) Str::uuid();
    }
}
