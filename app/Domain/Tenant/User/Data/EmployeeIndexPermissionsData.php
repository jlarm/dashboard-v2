<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Data;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, bool>
 */
final readonly class EmployeeIndexPermissionsData implements Arrayable
{
    public function __construct(
        public bool $manageFilters,
        public bool $emailReport,
        public bool $sendMessage,
    ) {}

    public static function forViewer(User $viewer): self
    {
        return new self(
            manageFilters: $viewer->can('create-stores'),
            emailReport: $viewer->can('create-dealerships'),
            sendMessage: $viewer->hasAnyRole(Role::values(Role::sendMessageRoles())),
        );
    }

    /**
     * @return array{manage_filters: bool, email_report: bool, send_message: bool}
     */
    public function toArray(): array
    {
        return [
            'manage_filters' => $this->manageFilters,
            'email_report' => $this->emailReport,
            'send_message' => $this->sendMessage,
        ];
    }
}
