<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Manuals\Isp\Data;

final readonly class IspManualFormData
{
    public function __construct(
        public string $signatureDataUri,
    ) {}
}
