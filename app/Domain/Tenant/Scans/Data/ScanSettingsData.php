<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Data;

use App\Models\Dealer\Store;

final readonly class ScanSettingsData
{
    public function __construct(
        public int $storeId,
        public string $storeName,
        public ?string $instanceId,
        public bool $isConnected,
    ) {}

    public static function fromStore(Store $store): self
    {
        $instanceUrl = $store->cyrisma->instance_url ?? null;

        $instanceId = $instanceUrl !== null && $instanceUrl !== ''
            ? str($instanceUrl)->before('.')->toString()
            : null;

        return new self(
            storeId: $store->id,
            storeName: (string) $store->name,
            instanceId: $instanceId,
            isConnected: $store->cyrisma !== null,
        );
    }

    /**
     * @return array{store_id: int, store_name: string, instance_id: ?string, is_connected: bool}
     */
    public function toArray(): array
    {
        return [
            'store_id' => $this->storeId,
            'store_name' => $this->storeName,
            'instance_id' => $this->instanceId,
            'is_connected' => $this->isConnected,
        ];
    }
}
