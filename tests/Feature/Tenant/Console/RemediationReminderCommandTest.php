<?php

declare(strict_types=1);

use App\Notifications\RemediationReminderNotification;
use Illuminate\Support\Facades\Notification;

it('runs without error when the tenant has no stores configured for remediation reminders', function (): void {
    Notification::fake();

    tenancy()->end();
    $this->artisan('remediation:reminder', ['--tenants' => [$this->tenant->id]])
        ->assertExitCode(0);

    Notification::assertNothingSent();
});

it('skips stores whose remediation settings have notifications disabled', function (): void {
    Notification::fake();

    $store = App\Models\Dealer\Store::query()->firstOrFail();
    App\Models\RemediationSetting::query()->create([
        'store_id' => $store->id,
        'active' => true,
        'notifications' => false,
        'frequency' => App\Enums\Frequency::WEEKLY,
    ]);

    tenancy()->end();
    $this->artisan('remediation:reminder', ['--tenants' => [$this->tenant->id]])
        ->assertExitCode(0);

    Notification::assertNothingSent();
});

it('iterates stores that have notifications enabled even when no due audits exist', function (): void {
    Notification::fake();

    $store = App\Models\Dealer\Store::query()->firstOrFail();
    App\Models\RemediationSetting::query()->create([
        'store_id' => $store->id,
        'active' => true,
        'notifications' => true,
        'frequency' => App\Enums\Frequency::WEEKLY,
    ]);

    tenancy()->end();
    $this->artisan('remediation:reminder', ['--tenants' => [$this->tenant->id]])
        ->assertExitCode(0);

    Notification::assertNothingSent(RemediationReminderNotification::class);
});
