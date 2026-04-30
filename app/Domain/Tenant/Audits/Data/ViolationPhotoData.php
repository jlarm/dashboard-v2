<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Data;

class ViolationPhotoData
{
    public function __construct(
        public readonly int $id,
        public readonly int $position,
        public readonly string $url,
    ) {}

    /**
     * @return array{id: int, position: int, url: string}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'position' => $this->position,
            'url' => $this->url,
        ];
    }
}
