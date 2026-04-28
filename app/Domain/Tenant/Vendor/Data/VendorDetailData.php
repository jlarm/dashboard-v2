<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Vendor\Data;

use App\Models\Dealer\Vendor;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Carbon;

/**
 * @implements Arrayable<string, mixed>
 */
final readonly class VendorDetailData implements Arrayable
{
    /**
     * Vendors created before this date used the legacy q1a–q22a column flow
     * directly on the vendors table; newer vendors flow through VendorForm.
     */
    private const string LEGACY_CUTOFF = '2024-06-23 00:00:00';

    /**
     * @param  array{id: int, name: string}|null  $store
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $contactName,
        public string $contactEmail,
        public ?array $store,
        public ?string $createdAt,
        public bool $hasLegacySignature,
        public bool $isLegacy,
    ) {}

    public static function fromModel(Vendor $vendor): self
    {
        return new self(
            id: (int) $vendor->id,
            name: (string) $vendor->name,
            contactName: (string) $vendor->contact_name,
            contactEmail: (string) $vendor->contact_email,
            store: $vendor->store
                ? ['id' => (int) $vendor->store->id, 'name' => (string) $vendor->store->name]
                : null,
            createdAt: $vendor->created_at?->toIso8601String(),
            hasLegacySignature: $vendor->signature !== null,
            isLegacy: $vendor->created_at !== null
                && $vendor->created_at->lessThan(Carbon::parse(self::LEGACY_CUTOFF)),
        );
    }

    /**
     * @return array{
     *     id: int,
     *     name: string,
     *     contact_name: string,
     *     contact_email: string,
     *     store: array{id: int, name: string}|null,
     *     created_at: string|null,
     *     has_legacy_signature: bool,
     *     is_legacy: bool
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'contact_name' => $this->contactName,
            'contact_email' => $this->contactEmail,
            'store' => $this->store,
            'created_at' => $this->createdAt,
            'has_legacy_signature' => $this->hasLegacySignature,
            'is_legacy' => $this->isLegacy,
        ];
    }
}
