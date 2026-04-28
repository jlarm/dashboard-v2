<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Vendor\Data;

final readonly class SendVendorFormData
{
    public function __construct(
        public string $name,
        public string $email,
    ) {}
}
