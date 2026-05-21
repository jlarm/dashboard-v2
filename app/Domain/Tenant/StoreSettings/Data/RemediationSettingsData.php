<?php

declare(strict_types=1);

namespace App\Domain\Tenant\StoreSettings\Data;

use App\Enums\AuditTypes;
use App\Models\Dealer\Store;
use App\Models\RemediationReminderPreference;
use App\Models\RemediationSetting;
use App\Models\User;

class RemediationSettingsData
{
    /**
     * @param  array<string, list<array{id: int, name: string, slug: ?string}>>  $reminder_groups
     */
    public function __construct(
        public readonly bool $active,
        public readonly bool $notifications,
        public readonly ?string $frequency,
        public readonly array $reminder_groups,
    ) {}

    public static function fromStore(Store $store): self
    {
        $settings = $store->remediationSettings;

        return new self(
            active: $settings instanceof RemediationSetting && (bool) $settings->active,
            notifications: $settings instanceof RemediationSetting && (bool) $settings->notifications,
            frequency: $settings instanceof RemediationSetting ? $settings->frequency->value : null,
            reminder_groups: self::reminderGroupsForStore($store),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'active' => $this->active,
            'notifications' => $this->notifications,
            'frequency' => $this->frequency,
            'reminder_groups' => $this->reminder_groups,
            'audit_types' => array_map(
                static fn (AuditTypes $type): array => ['value' => $type->value, 'label' => $type->label()],
                AuditTypes::cases(),
            ),
        ];
    }

    /**
     * @return array<string, list<array{id: int, name: string, slug: ?string}>>
     */
    private static function reminderGroupsForStore(Store $store): array
    {
        $multipleStores = (bool) (app()->bound('multipleStoresExist') ? resolve('multipleStoresExist') : false);

        $relevantUsers = ($multipleStores
            ? $store->users()->permission('create-users')
            : User::query()->permission('create-users'))
            ->get(['id', 'name', 'slug'])
            ->keyBy('id');

        $userIds = $relevantUsers->keys()->all();

        $preferences = RemediationReminderPreference::query()
            ->whereIn('user_id', $userIds)
            ->where('enabled', true)
            ->get()
            ->groupBy(fn (RemediationReminderPreference $preference): string => $preference->audit_type->value);

        $groups = [];

        foreach (AuditTypes::cases() as $type) {
            $entries = $preferences->get($type->value, collect())
                ->map(static fn (RemediationReminderPreference $preference): ?array => $relevantUsers->get($preference->user_id) instanceof User
                    ? [
                        'id' => (int) $relevantUsers->get($preference->user_id)->id,
                        'name' => (string) $relevantUsers->get($preference->user_id)->name,
                        'slug' => $relevantUsers->get($preference->user_id)->slug,
                    ]
                    : null)
                ->filter()
                ->values()
                ->all();

            $groups[$type->value] = $entries;
        }

        return $groups;
    }
}
