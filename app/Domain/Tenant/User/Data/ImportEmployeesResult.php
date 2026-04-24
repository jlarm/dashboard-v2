<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Data;

final readonly class ImportEmployeesResult
{
    /**
     * @param  list<array{row: int, errors: list<string>, values: array<string, mixed>}>  $errors
     */
    public function __construct(
        public int $successCount,
        public int $skippedCount,
        public array $errors,
    ) {}
}
