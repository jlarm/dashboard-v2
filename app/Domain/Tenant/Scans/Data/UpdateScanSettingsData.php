<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Data;

final readonly class UpdateScanSettingsData
{
    public function __construct(
        public int $storeId,
        public string $instanceId,
    ) {}
}
