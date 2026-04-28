<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Document\Data;

use Illuminate\Http\UploadedFile;

final readonly class CreateDealerDocData
{
    public function __construct(
        public string $title,
        public ?string $url,
        public ?UploadedFile $file,
    ) {}
}
