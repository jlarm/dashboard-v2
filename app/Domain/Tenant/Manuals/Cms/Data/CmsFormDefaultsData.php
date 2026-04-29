<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Manuals\Cms\Data;

final readonly class CmsFormDefaultsData
{
    public function __construct(
        public int $storeId,
        public string $storeName,
        public string $tenantName,
        public ?string $qualifiedIndividualName,
        public ?string $standardDppRate,
        public string $today,
        public string $todayDay,
        public string $todayMonth,
        public string $todayYear,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'store_id' => $this->storeId,
            'store_name' => $this->storeName,
            'tenant_name' => $this->tenantName,
            'qualified_individual_name' => $this->qualifiedIndividualName,
            'standard_dpp_rate' => $this->standardDppRate,
            'today' => $this->today,
            'today_day' => $this->todayDay,
            'today_month' => $this->todayMonth,
            'today_year' => $this->todayYear,
        ];
    }
}
