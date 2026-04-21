<?php

declare(strict_types=1);

namespace App\Domain\Central\Contracts\Actions;

use App\Jobs\Contracts\GeneratePdfJob;
use App\Jobs\Contracts\UploadToDigitalOceanJob;
use App\Models\Contract;
use Illuminate\Support\Facades\Bus;

class GenerateContractPdf
{
    public function handle(Contract $contract): void
    {
        Bus::chain([
            new GeneratePdfJob($contract),
            new UploadToDigitalOceanJob($contract),
        ])->dispatch();
    }
}
