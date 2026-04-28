<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Sds\Data;

use App\Models\Sds;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
final readonly class SdsRecordData implements Arrayable
{
    public function __construct(
        public string $uuid,
        public string $name,
        public ?string $manufacturer,
    ) {}

    public static function fromModel(Sds $sds): self
    {
        return new self(
            uuid: (string) $sds->uuid,
            name: (string) $sds->name,
            manufacturer: $sds->manufacturer,
        );
    }

    /**
     * @return array{uuid: string, name: string, manufacturer: string|null}
     */
    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'manufacturer' => $this->manufacturer,
        ];
    }
}
