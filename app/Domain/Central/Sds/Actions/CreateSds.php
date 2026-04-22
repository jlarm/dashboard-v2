<?php

declare(strict_types=1);

namespace App\Domain\Central\Sds\Actions;

use App\Domain\Central\Sds\Data\SdsData;
use App\Domain\Central\Sds\Support\SdsStorage;
use App\Models\Sds;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class CreateSds
{
    public function __construct(
        private readonly SdsStorage $storage,
    ) {}

    public function handle(SdsData $data): Sds
    {
        return DB::transaction(function () use ($data): Sds {
            $fileName = $data->file instanceof UploadedFile ? $this->storage->store($data->file) : null;

            return Sds::query()->create([
                'name' => $data->name,
                'manufacturer' => $data->manufacturer,
                'keywords' => $data->keywords,
                'file_name' => $fileName,
            ]);
        });
    }
}
