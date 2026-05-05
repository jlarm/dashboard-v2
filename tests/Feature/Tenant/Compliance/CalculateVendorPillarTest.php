<?php

declare(strict_types=1);

use App\Domain\Tenant\Compliance\Queries\CalculateVendorPillar;
use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorForm;
use Carbon\CarbonImmutable;

it('marks the pillar as not applicable when the store has no vendors', function (): void {
    $store = Store::query()->firstOrFail();

    $pillar = (new CalculateVendorPillar())->handle($store, CarbonImmutable::now());

    expect($pillar->applicable)->toBeFalse();
});

it('scores 100 when every vendor has a fresh signed form', function (): void {
    $store = Store::query()->firstOrFail();

    $vendor = makeVendor($store);
    makeForm($vendor, signedAt: CarbonImmutable::now()->subMonths(3));

    $pillar = (new CalculateVendorPillar())->handle($store, CarbonImmutable::now());

    expect($pillar->score)->toBe(100.0);
    expect($pillar->breakdown['fresh_completed'])->toBe(1);
    expect($pillar->breakdown['outstanding'])->toBe(0);
});

it('treats forms older than 12 months as half-credit', function (): void {
    $store = Store::query()->firstOrFail();

    $fresh = makeVendor($store, 'Fresh Vendor');
    makeForm($fresh, signedAt: CarbonImmutable::now()->subMonths(2));

    $stale = makeVendor($store, 'Stale Vendor');
    makeForm($stale, signedAt: CarbonImmutable::now()->subMonths(18));

    $pillar = (new CalculateVendorPillar())->handle($store, CarbonImmutable::now());

    // 1.0 + 0.5 = 1.5 effective / 2 vendors = 75%
    expect($pillar->score)->toBe(75.0);
    expect($pillar->breakdown['fresh_completed'])->toBe(1);
    expect($pillar->breakdown['stale_completed'])->toBe(1);
});

it('counts vendors with no completed form as outstanding', function (): void {
    $store = Store::query()->firstOrFail();

    $signed = makeVendor($store, 'Signed');
    makeForm($signed, signedAt: CarbonImmutable::now()->subMonths(1));

    $unsigned = makeVendor($store, 'Unsigned');
    VendorForm::query()->create([
        'vendor_id' => $unsigned->id,
        'name' => $unsigned->contact_name,
        'email' => $unsigned->contact_email,
    ]);

    $pillar = (new CalculateVendorPillar())->handle($store, CarbonImmutable::now());

    // 1 fresh / 2 vendors = 50%
    expect($pillar->score)->toBe(50.0);
    expect($pillar->breakdown['outstanding'])->toBe(1);
});

function makeVendor(Store $store, string $name = 'Acme Vendor'): Vendor
{
    return Vendor::query()->create([
        'name' => $name.' '.uniqid(),
        'contact_name' => 'Contact',
        'contact_email' => 'contact-'.uniqid().'@example.com',
        'store_id' => $store->id,
    ]);
}

function makeForm(Vendor $vendor, CarbonImmutable $signedAt): VendorForm
{
    $form = VendorForm::query()->create([
        'vendor_id' => $vendor->id,
        'name' => $vendor->contact_name,
        'email' => $vendor->contact_email,
        'signature' => 'data:image/png;base64,signed',
    ]);

    VendorForm::query()->where('id', $form->id)->update([
        'created_at' => $signedAt,
        'updated_at' => $signedAt,
    ]);

    return $form->refresh();
}
