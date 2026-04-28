<?php

declare(strict_types=1);

namespace App\Domain\Tenant\GlobalSettings\Data;

final readonly class UpdatePhishingSettingsData
{
    public function __construct(
        public bool $active,
        public ?string $token,
        public ?string $ip,
    ) {}
}
