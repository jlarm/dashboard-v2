<?php

declare(strict_types=1);

namespace App\Domain\Central\Contracts\Support;

use App\Models\Contract;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContractSignatureStorage
{
    private const string DISK = 'armpcon';

    public function storeDataUri(Contract $contract, string $dataUri): string
    {
        $binary = base64_decode((string) Str::of($dataUri)->after(','), true);

        abort_if($binary === false, 422, 'Invalid signature payload.');

        $path = $contract->uuid.'/'.Str::uuid().'.png';

        Storage::disk(self::DISK)->put($path, $binary);

        return $path;
    }

    public function temporaryUrl(string $path, int $minutes = 5): string
    {
        return Storage::disk(self::DISK)->temporaryUrl($path, now()->addMinutes($minutes));
    }
}
