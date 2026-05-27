<?php

declare(strict_types=1);

use App\Jobs\IncompleteVendorNotificationJob;
use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorForm;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Bus;

beforeEach(function (): void {
    Carbon::setTestNow('2026-06-15 12:00:00');

    $this->vendor = Vendor::query()->create([
        'name' => 'Acme Supplies',
        'contact_name' => 'Sam Vendor',
        'contact_email' => 'sam@vendor.test',
    ]);
});

afterEach(function (): void {
    Carbon::setTestNow();
});

it('queues IncompleteVendorNotificationJob and updates last_notification_sent_at for never-notified incomplete forms', function (): void {
    Bus::fake();

    $form = VendorForm::query()->create([
        'vendor_id' => $this->vendor->id,
        'name' => 'Acme Supplies',
        'email' => 'sam@vendor.test',
    ]);

    tenancy()->end();
    $this->artisan('vendor:send-notification', ['--tenants' => [$this->tenant->id]])->assertSuccessful();

    Bus::assertDispatched(IncompleteVendorNotificationJob::class);

    $this->tenant->run(function () use ($form): void {
        expect($form->fresh()->last_notification_sent_at?->toDateTimeString())->toBe('2026-06-15 12:00:00');
    });
});

it('queues a notification when the previous attempt is older than one month', function (): void {
    Bus::fake();

    $form = VendorForm::query()->create([
        'vendor_id' => $this->vendor->id,
        'name' => 'Acme Supplies',
        'email' => 'sam@vendor.test',
        'last_notification_sent_at' => Carbon::parse('2026-05-01 12:00:00'),
    ]);

    tenancy()->end();
    $this->artisan('vendor:send-notification', ['--tenants' => [$this->tenant->id]])->assertSuccessful();

    Bus::assertDispatched(IncompleteVendorNotificationJob::class);
});

it('skips forms that already have a signature', function (): void {
    Bus::fake();

    VendorForm::query()->create([
        'vendor_id' => $this->vendor->id,
        'name' => 'Acme Supplies',
        'email' => 'sam@vendor.test',
        'signature' => 'already-signed.png',
    ]);

    tenancy()->end();
    $this->artisan('vendor:send-notification', ['--tenants' => [$this->tenant->id]])->assertSuccessful();

    Bus::assertNotDispatched(IncompleteVendorNotificationJob::class);
});

it('skips forms whose last_notification_sent_at is within the past month', function (): void {
    Bus::fake();

    VendorForm::query()->create([
        'vendor_id' => $this->vendor->id,
        'name' => 'Acme Supplies',
        'email' => 'sam@vendor.test',
        'last_notification_sent_at' => Carbon::parse('2026-06-10 12:00:00'),
    ]);

    tenancy()->end();
    $this->artisan('vendor:send-notification', ['--tenants' => [$this->tenant->id]])->assertSuccessful();

    Bus::assertNotDispatched(IncompleteVendorNotificationJob::class);
});
