<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Vendor\Data;

use App\Models\Dealer\Vendor;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
final readonly class VendorListData implements Arrayable
{
    /**
     * @param  array{id: int, name: string}|null  $store
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $contactName,
        public string $contactEmail,
        public ?array $store,
        public bool $isCompleted,
    ) {}

    public static function fromModel(Vendor $vendor): self
    {
        $latestForm = $vendor->latestForm;
        $isCompleted = $latestForm !== null
            && ($latestForm->signature !== null || $latestForm->document_path !== null);

        return new self(
            id: (int) $vendor->id,
            name: (string) $vendor->name,
            contactName: (string) $vendor->contact_name,
            contactEmail: (string) $vendor->contact_email,
            store: $vendor->store
                ? ['id' => (int) $vendor->store->id, 'name' => (string) $vendor->store->name]
                : null,
            isCompleted: $isCompleted,
        );
    }

    /**
     * @return array{
     *     id: int,
     *     name: string,
     *     contact_name: string,
     *     contact_email: string,
     *     store: array{id: int, name: string}|null,
     *     is_completed: bool
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
            'is_completed' => $this->isCompleted,
        ];
    }
}
