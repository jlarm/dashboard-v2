<?php

declare(strict_types=1);

namespace App\Domain\Central\User\Data;

class CreateInviteData
{
    public function __construct(
        public string $name,
        public string $email,
    ) {}
}
