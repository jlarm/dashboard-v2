<?php

declare(strict_types=1);

namespace App\Domain\Central\Documents\Data;

use Illuminate\Http\UploadedFile;

final readonly class DocumentData
{
    public function __construct(
        public string $title,
        public ?string $url,
        public ?UploadedFile $file,
    ) {}
}
