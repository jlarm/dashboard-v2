<?php

declare(strict_types=1);

namespace App\Http\Resources\Central;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Override;

/**
 * @mixin Document
 */
class DocumentResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'url' => $this->url,
            'file_name' => $this->file_name ? Str::lower($this->file_name) : null,
            'download_url' => $this->file_name ? route('documents.download', $this->resource) : null,
        ];
    }
}
