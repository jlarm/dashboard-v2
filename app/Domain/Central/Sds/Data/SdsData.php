<?php

declare(strict_types=1);

namespace App\Domain\Central\Sds\Data;

use Illuminate\Http\UploadedFile;

final readonly class SdsData
{
    /**
     * @param  array<int, string>  $keywords
     */
    public function __construct(
        public string $name,
        public string $manufacturer,
        public array $keywords,
        public ?UploadedFile $file,
    ) {}
}
