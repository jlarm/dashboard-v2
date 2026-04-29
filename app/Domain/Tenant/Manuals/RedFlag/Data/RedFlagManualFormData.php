<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Manuals\RedFlag\Data;

final readonly class RedFlagManualFormData
{
    public function __construct(
        public string $signatureDataUri,
    ) {}
}
