<?php

declare(strict_types=1);

namespace App\Domain\Central\Dealership\Data;

final readonly class DealershipData
{
    /**
     * @param  array<int, int>  $consultantIds
     */
    public function __construct(
        public string $name,
        public array $consultantIds = [],
    ) {}
}
