<?php

declare(strict_types=1);

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

/**
 * @property string $key
 * @property int $id
 * @property string $title
 * @property string|null $url
 * @property string|null $download_url
 * @property bool $is_shared
 */
class DealerDocListItemResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'key' => $this->resource['key'],
            'id' => $this->resource['id'],
            'title' => $this->resource['title'],
            'url' => $this->resource['url'],
            'download_url' => $this->resource['download_url'],
            'is_shared' => $this->resource['is_shared'],
        ];
    }
}
