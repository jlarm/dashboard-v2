<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Sds\Data;

final readonly class RequestSdsSheetData
{
    public function __construct(
        public string $chemicalName,
        public ?string $manufacturer,
        public string $requesterName,
        public string $requesterEmail,
    ) {}
}
