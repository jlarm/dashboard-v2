<?php

declare(strict_types=1);

namespace App\Http\Resources\Central;

use App\Models\Sds;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

/**
 * @mixin Sds
 */
class SdsResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'manufacturer' => $this->manufacturer,
            'keywords' => $this->keywords ?? [],
            'file_name' => $this->file_name,
            'download_url' => $this->file_name !== ''
                ? route('sds.download', $this->resource)
                : null,
        ];
    }
}
