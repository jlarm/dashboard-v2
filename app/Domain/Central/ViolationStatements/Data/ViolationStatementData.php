<?php

declare(strict_types=1);

namespace App\Domain\Central\ViolationStatements\Data;

use App\Enums\ViolationStatementCategory;
use Illuminate\Http\UploadedFile;

final readonly class ViolationStatementData
{
    /**
     * @param  list<ViolationStatementCategory>  $categories
     * @param  list<string>|null  $keywords
     */
    public function __construct(
        public string $statement,
        public int $weight,
        public array $categories,
        public ?array $keywords,
        public ?UploadedFile $image,
    ) {}
}
