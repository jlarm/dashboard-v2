<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Vendor\Data;

use App\Models\Dealer\VendorEmailLog;
use App\Models\Dealer\VendorForm;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
final readonly class VendorFormData implements Arrayable
{
    /**
     * @param  list<VendorEmailLogData>  $emailLogs
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $createdAt,
        public bool $isCompleted,
        public array $emailLogs,
    ) {}

    public static function fromModel(VendorForm $form): self
    {
        $emailLogs = $form->relationLoaded('emailLogs')
            ? array_values(
                $form->emailLogs
                    ->map(static fn (VendorEmailLog $log): VendorEmailLogData => VendorEmailLogData::fromModel($log))
                    ->all(),
            )
            : [];

        return new self(
            id: (int) $form->id,
            name: (string) $form->name,
            email: (string) $form->email,
            createdAt: $form->created_at?->toIso8601String(),
            isCompleted: $form->signature !== null || $form->document_path !== null,
            emailLogs: $emailLogs,
        );
    }

    /**
     * @return array{
     *     id: int,
     *     name: string,
     *     email: string,
     *     created_at: string|null,
     *     is_completed: bool,
     *     email_logs: list<array<string, mixed>>
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->createdAt,
            'is_completed' => $this->isCompleted,
            'email_logs' => array_map(
                static fn (VendorEmailLogData $log): array => $log->toArray(),
                $this->emailLogs,
            ),
        ];
    }
}
