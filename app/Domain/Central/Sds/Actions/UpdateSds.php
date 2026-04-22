<?php

declare(strict_types=1);

namespace App\Domain\Central\Sds\Actions;

use App\Domain\Central\Sds\Data\SdsData;
use App\Domain\Central\Sds\Support\SdsStorage;
use App\Models\Sds;
use Illuminate\Support\Facades\DB;

class UpdateSds
{
    public function __construct(
        private readonly SdsStorage $storage,
    ) {}

    public function handle(Sds $sds, SdsData $data): Sds
    {
        return DB::transaction(function () use ($sds, $data): Sds {
            $fileName = $sds->file_name;

            if ($data->file !== null) {
                $this->storage->delete($sds->file_name);
                $fileName = $this->storage->store($data->file);
            }

            $sds->update([
                'name' => $data->name,
                'manufacturer' => $data->manufacturer,
                'keywords' => $data->keywords,
                'file_name' => $fileName,
            ]);

            return $sds->refresh();
        });
    }
}
