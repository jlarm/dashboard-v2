<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Vendor\Data;

use App\Models\Dealer\VendorForm;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
final readonly class VendorPublicFormData implements Arrayable
{
    public function __construct(
        public int $id,
        public string $vendorName,
        public string $contactName,
    ) {}

    public static function fromModel(VendorForm $form): self
    {
        return new self(
            id: (int) $form->id,
            vendorName: (string) $form->vendor->name,
            contactName: (string) $form->name,
        );
    }

    /**
     * @return array{id: int, vendor_name: string, contact_name: string}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'vendor_name' => $this->vendorName,
            'contact_name' => $this->contactName,
        ];
    }
}
