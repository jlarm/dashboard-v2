<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Data;

use Illuminate\Http\UploadedFile;

final readonly class UploadScanReportData
{
    public function __construct(
        public int $userId,
        public int $storeId,
        public string $scanType,
        public string $summaryType,
        public ?string $createdAt,
        public UploadedFile $file,
    ) {}
}
