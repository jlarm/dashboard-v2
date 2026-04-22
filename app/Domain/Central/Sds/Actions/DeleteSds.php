<?php

declare(strict_types=1);

namespace App\Domain\Central\Sds\Actions;

use App\Domain\Central\Sds\Support\SdsStorage;
use App\Models\Sds;
use Illuminate\Support\Facades\DB;

class DeleteSds
{
    public function __construct(
        private readonly SdsStorage $storage,
    ) {}

    public function handle(Sds $sds): void
    {
        DB::transaction(function () use ($sds): void {
            $this->storage->delete($sds->file_name);
            $sds->delete();
        });
    }
}
