<?php

declare(strict_types=1);

namespace App\Http\Resources\Central;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Override;

class SharedDocumentResource extends JsonResource
{
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'url' => $this->url,
            'file_name' => $this->file_name ? Str::lower(Str::after($this->file_name, 'shared-documents/')) : null,
            'download_url' => $this->file_name ? route('shared-documents.download', $this->resource) : null,
        ];
    }
}
