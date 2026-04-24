<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Data;

final readonly class EmployeeFiltersData
{
    /**
     * @param  list<int>  $departmentIds
     * @param  list<int>  $roleIds
     */
    public function __construct(
        public string $search,
        public array $departmentIds,
        public array $roleIds,
        public bool $onlyIncomplete,
        public bool $onlyExpired,
        public bool $onlyExpiringSoon,
        public string $sortField,
        public string $sortDirection,
    ) {}

    public static function empty(): self
    {
        return new self(
            search: '',
            departmentIds: [],
            roleIds: [],
            onlyIncomplete: false,
            onlyExpired: false,
            onlyExpiringSoon: false,
            sortField: 'name',
            sortDirection: 'asc',
        );
    }

    public function hasComplianceFilter(): bool
    {
        return $this->onlyIncomplete || $this->onlyExpired || $this->onlyExpiringSoon;
    }

    /**
     * @return array{
     *     search: string,
     *     department_ids: list<int>,
     *     role_ids: list<int>,
     *     only_incomplete: bool,
     *     only_expired: bool,
     *     only_expiring_soon: bool,
     *     sort_field: string,
     *     sort_direction: string
     * }
     */
    public function toArray(): array
    {
        return [
            'search' => $this->search,
            'department_ids' => $this->departmentIds,
            'role_ids' => $this->roleIds,
            'only_incomplete' => $this->onlyIncomplete,
            'only_expired' => $this->onlyExpired,
            'only_expiring_soon' => $this->onlyExpiringSoon,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
    }
}
