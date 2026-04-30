<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Data;

use App\Models\ViolationStatement;

class ViolationStatementSearchResultData
{
    public function __construct(
        public readonly int $id,
        public readonly string $statement,
        public readonly ?string $referenceImageUrl,
    ) {}

    public static function fromModel(ViolationStatement $statement): self
    {
        return new self(
            id: (int) $statement->getKey(),
            statement: (string) $statement->statement,
            referenceImageUrl: $statement->reference_image_url,
        );
    }

    /**
     * @return array{id: int, statement: string, reference_image_url: ?string}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'statement' => $this->statement,
            'reference_image_url' => $this->referenceImageUrl,
        ];
    }
}
