<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Manuals\RedFlag\Queries;

use App\Domain\Tenant\Manuals\RedFlag\Data\RedFlagFormDefaultsData;
use App\Models\Dealer\Settings\EmployeeList;
use App\Models\Dealer\Store;

class BuildRedFlagFormDefaults
{
    public function handle(Store $store): RedFlagFormDefaultsData
    {
        $employeeList = EmployeeList::query()
            ->where('store_id', $store->id)
            ->first();

        return new RedFlagFormDefaultsData(
            storeId: (int) $store->id,
            storeName: (string) $store->name,
            qualifiedIndividualName: (string) ($employeeList->qualified_individual_name ?? ''),
            qualifiedIndividualPhone: (string) ($employeeList->qualified_individual_phone ?? ''),
            ownerName: (string) ($employeeList->owner_name ?? ''),
            ownerPhone: (string) ($employeeList->owner_phone ?? ''),
            generalManagerName: (string) ($employeeList->general_manager_name ?? ''),
            generalManagerPhone: (string) ($employeeList->general_manager_phone ?? ''),
            serviceManagerName: (string) ($employeeList->service_manager_name ?? ''),
            serviceManagerPhone: (string) ($employeeList->service_manager_phone ?? ''),
            partsManagerName: (string) ($employeeList->parts_manager_name ?? ''),
            partsManagerPhone: (string) ($employeeList->parts_manager_phone ?? ''),
            bodyShopManagerName: (string) ($employeeList->body_shop_manager_name ?? ''),
            bodyShopManagerPhone: (string) ($employeeList->body_shop_manager_phone ?? ''),
            policeEmergencyPhone: (string) ($store->police_emergency_phone ?? ''),
            policeNonEmergencyPhone: (string) ($store->police_non_emergency_phone ?? ''),
            fireEmergencyPhone: (string) ($store->fire_emergency_phone ?? ''),
            fireNonEmergencyPhone: (string) ($store->fire_non_emergency_phone ?? ''),
            fireAlarmType: (string) ($store->fire_alarm_type ?? ''),
            burglarAlarmType: (string) ($store->burglar_alarm_type ?? ''),
        );
    }
}
