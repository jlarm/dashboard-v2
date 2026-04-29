<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Manuals\Isp\Data;

final readonly class IspFormDefaultsData
{
    public function __construct(
        public int $storeId,
        public string $storeName,
        public string $qualifiedIndividualName,
        public string $qualifiedIndividualPhone,
        public string $ownerName,
        public string $ownerPhone,
        public string $generalManagerName,
        public string $generalManagerPhone,
        public string $serviceManagerName,
        public string $serviceManagerPhone,
        public string $partsManagerName,
        public string $partsManagerPhone,
        public string $bodyShopManagerName,
        public string $bodyShopManagerPhone,
        public string $policeEmergencyPhone,
        public string $policeNonEmergencyPhone,
        public string $fireEmergencyPhone,
        public string $fireNonEmergencyPhone,
        public string $fireAlarmType,
        public string $burglarAlarmType,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'store_id' => $this->storeId,
            'store_name' => $this->storeName,
            'qualified_individual_name' => $this->qualifiedIndividualName,
            'qualified_individual_phone' => $this->qualifiedIndividualPhone,
            'owner_name' => $this->ownerName,
            'owner_phone' => $this->ownerPhone,
            'general_manager_name' => $this->generalManagerName,
            'general_manager_phone' => $this->generalManagerPhone,
            'service_manager_name' => $this->serviceManagerName,
            'service_manager_phone' => $this->serviceManagerPhone,
            'parts_manager_name' => $this->partsManagerName,
            'parts_manager_phone' => $this->partsManagerPhone,
            'body_shop_manager_name' => $this->bodyShopManagerName,
            'body_shop_manager_phone' => $this->bodyShopManagerPhone,
            'police_emergency_phone' => $this->policeEmergencyPhone,
            'police_non_emergency_phone' => $this->policeNonEmergencyPhone,
            'fire_emergency_phone' => $this->fireEmergencyPhone,
            'fire_non_emergency_phone' => $this->fireNonEmergencyPhone,
            'fire_alarm_type' => $this->fireAlarmType,
            'burglar_alarm_type' => $this->burglarAlarmType,
        ];
    }
}
