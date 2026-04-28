<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Vendor\Data;

use App\Models\Dealer\VendorEmailLog;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
final readonly class VendorEmailLogData implements Arrayable
{
    public function __construct(
        public int $id,
        public ?string $eventType,
        public ?string $deliveryMessage,
        public ?string $sentAt,
    ) {}

    public static function fromModel(VendorEmailLog $log): self
    {
        return new self(
            id: (int) $log->id,
            eventType: $log->event_type,
            deliveryMessage: $log->delivery_message,
            sentAt: $log->sent_at?->toIso8601String(),
        );
    }

    /**
     * @return array{id: int, event_type: string|null, delivery_message: string|null, sent_at: string|null}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'event_type' => $this->eventType,
            'delivery_message' => $this->deliveryMessage,
            'sent_at' => $this->sentAt,
        ];
    }
}
