<?php

declare(strict_types=1);

namespace App\Domain\Tenant\GlobalSettings\Data;

use App\Models\Dealer\Store;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
final readonly class StoreSettingData implements Arrayable
{
    public function __construct(
        public int $id,
        public string $name,
        public bool $coursesNotTakenNotification,
        public bool $remediationsActive,
    ) {}

    public static function fromModel(Store $store): self
    {
        return new self(
            id: (int) $store->id,
            name: (string) $store->name,
            coursesNotTakenNotification: (bool) $store->courses_not_taken_notification,
            remediationsActive: (bool) ($store->remediationSettings->active ?? false),
        );
    }

    /**
     * @return array{id: int, name: string, courses_not_taken_notification: bool, remediations_active: bool}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'courses_not_taken_notification' => $this->coursesNotTakenNotification,
            'remediations_active' => $this->remediationsActive,
        ];
    }
}
