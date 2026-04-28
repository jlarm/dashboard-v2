<?php

declare(strict_types=1);

use App\Models\Dealer\Invite;
use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Store;
use App\Models\Dealer\StoreSettings;
use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorForm;
use Spatie\Activitylog\Models\Activity;

/**
 * Guards against regressions: any field listed here in `logExcept`
 * must never appear in activity log property snapshots.
 */
describe('Activity log redaction', function (): void {
    it('does not log invitation_token on Invite changes', function (): void {
        $invite = Invite::query()->create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'invitation_token' => 'secret-token-value',
            'roles' => ['Employee'],
        ]);

        $log = Activity::query()
            ->where('subject_type', $invite::class)
            ->where('subject_id', $invite->id)
            ->latest('id')
            ->first();

        expect($log)->not->toBeNull()
            ->and($log->properties->toArray())->not->toHaveKey('invitation_token');
    });

    it('does not log phishing_token, phishing_ip, or ip_addresses on Store changes', function (): void {
        $store = Store::query()->firstOrFail();
        $store->update([
            'phishing_token' => 'secret-phish-token',
            'phishing_ip' => '10.0.0.1',
            'ip_addresses' => '192.168.1.1, 192.168.1.2',
        ]);

        $log = Activity::query()
            ->where('subject_type', $store::class)
            ->where('subject_id', $store->id)
            ->latest('id')
            ->first();

        expect($log)->not->toBeNull();

        $properties = collect($log->properties->toArray())->flatMap(fn ($attrs) => is_array($attrs) ? $attrs : [])->keys();

        expect($properties)->not->toContain('phishing_token')
            ->and($properties)->not->toContain('phishing_ip')
            ->and($properties)->not->toContain('ip_addresses');
    });

    it('does not log ip_addresses on StoreSettings changes', function (): void {
        $store = Store::query()->firstOrFail();
        $settings = StoreSettings::query()->create([
            'store_id' => $store->id,
            'name' => 'Test',
            'ip_addresses' => '192.168.1.1',
        ]);

        $log = Activity::query()
            ->where('subject_type', $settings::class)
            ->where('subject_id', $settings->id)
            ->latest('id')
            ->first();

        expect($log)->not->toBeNull();

        $properties = collect($log->properties->toArray())->flatMap(fn ($attrs) => is_array($attrs) ? $attrs : [])->keys();

        expect($properties)->not->toContain('ip_addresses');
    });

    it('does not log signature on Vendor or VendorForm changes', function (): void {
        $store = Store::query()->firstOrFail();
        $vendor = Vendor::query()->create([
            'name' => 'Acme',
            'contact_name' => 'Vendor Contact',
            'contact_email' => 'vendor@example.com',
            'store_id' => $store->id,
            'signature' => 'data:image/png;base64,abcdef',
        ]);

        $vendorForm = VendorForm::query()->create([
            'vendor_id' => $vendor->id,
            'name' => 'Vendor Person',
            'email' => 'vp@example.com',
            'signature' => 'data:image/png;base64,signature',
            'data' => ['secret_field' => 'leak-me'],
        ]);

        $vendorLog = Activity::query()
            ->where('subject_type', $vendor::class)
            ->where('subject_id', $vendor->id)
            ->latest('id')
            ->first();
        $vendorFormLog = Activity::query()
            ->where('subject_type', $vendorForm::class)
            ->where('subject_id', $vendorForm->id)
            ->latest('id')
            ->first();

        $vendorProps = collect($vendorLog?->properties->toArray() ?? [])->flatMap(fn ($a) => is_array($a) ? $a : [])->keys();
        $formProps = collect($vendorFormLog?->properties->toArray() ?? [])->flatMap(fn ($a) => is_array($a) ? $a : [])->keys();

        expect($vendorProps)->not->toContain('signature')
            ->and($formProps)->not->toContain('signature')
            ->and($formProps)->not->toContain('data');
    });

    it('does not log signature on Isp, Osha, or RedFlag manuals', function (): void {
        $store = Store::query()->firstOrFail();

        $manuals = [
            Isp::query()->create(['store_id' => $store->id, 'signature' => 'sig-isp']),
            Osha::query()->create(['store_id' => $store->id, 'signature' => 'sig-osha']),
            RedFlag::query()->create(['store_id' => $store->id, 'signature' => 'sig-redflag']),
        ];

        foreach ($manuals as $manual) {
            $log = Activity::query()
                ->where('subject_type', $manual::class)
                ->where('subject_id', $manual->id)
                ->latest('id')
                ->first();

            $properties = collect($log?->properties->toArray() ?? [])->flatMap(fn ($a) => is_array($a) ? $a : [])->keys();

            expect($properties)->not->toContain('signature');
        }
    });
});
