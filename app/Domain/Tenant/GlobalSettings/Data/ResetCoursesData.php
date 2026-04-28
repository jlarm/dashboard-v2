<?php

declare(strict_types=1);

namespace App\Domain\Tenant\GlobalSettings\Data;

final readonly class ResetCoursesData
{
    public const string MODE_EVERYONE = 'everyone';

    public const string MODE_SELECTED_USERS = 'selected-users';

    /**
     * @param  list<int>  $selectedUserIds
     */
    public function __construct(
        public string $mode,
        public array $selectedUserIds,
    ) {}

    public function isSelectedUsers(): bool
    {
        return $this->mode === self::MODE_SELECTED_USERS;
    }
}
