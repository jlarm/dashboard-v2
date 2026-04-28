<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Vendor\Data;

final readonly class CreateVendorData
{
    public function __construct(
        public string $name,
        public string $contactName,
        public string $contactEmail,
        public ?int $storeId,
    ) {}
}
