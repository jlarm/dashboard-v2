<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Data;

final readonly class ScanReportData
{
    public function __construct(
        public string $type,
        public string $fileName,
        public string $pdfBinary,
    ) {}
}
