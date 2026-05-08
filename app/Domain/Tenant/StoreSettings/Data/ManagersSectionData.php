<?php

declare(strict_types=1);

namespace App\Domain\Tenant\StoreSettings\Data;

use App\Models\Dealer\Settings\EmployeeList;
use App\Models\Dealer\Store;

class ManagersSectionData
{
    public function __construct(
        public readonly ?string $qualified_individual_name,
        public readonly ?string $qualified_individual_phone,
        public readonly ?string $service_manager_name,
        public readonly ?string $service_manager_phone,
        public readonly ?string $parts_manager_name,
        public readonly ?string $parts_manager_phone,
        public readonly ?string $body_shop_manager_name,
        public readonly ?string $body_shop_manager_phone,
        public readonly ?string $general_manager_name,
        public readonly ?string $general_manager_phone,
        public readonly ?string $owner_name,
        public readonly ?string $owner_phone,
    ) {}

    public static function fromStore(Store $store): self
    {
        $list = EmployeeList::query()->where('store_id', $store->id)->first();

        return new self(
            qualified_individual_name: $list?->qualified_individual_name,
            qualified_individual_phone: $list?->qualified_individual_phone,
            service_manager_name: $list?->service_manager_name,
            service_manager_phone: $list?->service_manager_phone,
            parts_manager_name: $list?->parts_manager_name,
            parts_manager_phone: $list?->parts_manager_phone,
            body_shop_manager_name: $list?->body_shop_manager_name,
            body_shop_manager_phone: $list?->body_shop_manager_phone,
            general_manager_name: $list?->general_manager_name,
            general_manager_phone: $list?->general_manager_phone,
            owner_name: $list?->owner_name,
            owner_phone: $list?->owner_phone,
        );
    }

    /**
     * @return array<string, string|null>
     */
    public function toArray(): array
    {
        return [
            'qualified_individual_name' => $this->qualified_individual_name,
            'qualified_individual_phone' => $this->qualified_individual_phone,
            'service_manager_name' => $this->service_manager_name,
            'service_manager_phone' => $this->service_manager_phone,
            'parts_manager_name' => $this->parts_manager_name,
            'parts_manager_phone' => $this->parts_manager_phone,
            'body_shop_manager_name' => $this->body_shop_manager_name,
            'body_shop_manager_phone' => $this->body_shop_manager_phone,
            'general_manager_name' => $this->general_manager_name,
            'general_manager_phone' => $this->general_manager_phone,
            'owner_name' => $this->owner_name,
            'owner_phone' => $this->owner_phone,
        ];
    }
}
