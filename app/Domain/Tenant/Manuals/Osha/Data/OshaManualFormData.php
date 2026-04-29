<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Manuals\Osha\Data;

final readonly class OshaManualFormData
{
    public function __construct(
        public string $signatureDataUri,
    ) {}
}
