<?php

declare(strict_types=1);

namespace App\Domain\Tenant\FitTests\Data;

use Illuminate\Http\UploadedFile;

final readonly class CreateFitTestData
{
    public function __construct(
        public int $userId,
        public string $employeeName,
        public string $date,
        public UploadedFile $file,
    ) {}
}
