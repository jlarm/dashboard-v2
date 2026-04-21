<?php

declare(strict_types=1);

namespace App\Domain\Central\SharedDocuments\Data;

use Illuminate\Http\UploadedFile;

final readonly class SharedDocumentData
{
    public function __construct(
        public string $title,
        public ?string $url,
        public ?UploadedFile $file,
    ) {}
}
