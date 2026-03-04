<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Audit\Osha\Index as OshaAuditIndex;
use App\Http\Livewire\Dealer\Vendor\Index as VendorIndex;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use App\Models\User;
use Livewire\Livewire;

describe('shared store scope filtering', function (): void {
    it('filters osha audits by selected current_store_id', function (): void {
        $this->tenant->locations = true;
        $this->tenant->save();

        $storeA = Store::query()->firstOrFail();
        $storeB = Store::query()->create([
            'name' => 'Audit Scope Store B '.uniqid(),
            'slug' => 'audit-scope-store-b-'.uniqid(),
            'state' => 'IN',
        ]);

        $manager = User::query()->create([
            'name' => 'Audit Scope Manager',
            'email' => 'audit-scope-manager@test.com',
            'password' => bcrypt('password'),
            'current_store_id' => $storeA->id,
        ]);
        $manager->assignRole('Manager');
        $manager->stores()->attach([$storeA->id, $storeB->id]);

        OshaViolationAudit::query()->create([
            'uuid' => (string) str()->uuid(),
            'user_id' => $manager->id,
            'store_id' => $storeA->id,
            'date' => now()->subDay()->toDateString(),
            'grade' => 'A',
        ]);

        OshaViolationAudit::query()->create([
            'uuid' => (string) str()->uuid(),
            'user_id' => $manager->id,
            'store_id' => $storeB->id,
            'date' => now()->toDateString(),
            'grade' => 'B',
        ]);

        $this->actingAs($manager);
        app()->instance('currentStore', $storeA->id);
        app()->instance('scopedStoreIds', collect([$storeA->id]));

        Livewire::test(OshaAuditIndex::class)
            ->assertOk()
            ->assertViewHas('audits', function ($audits) use ($storeA, $storeB): bool {
                $storeIds = $audits->pluck('store_id')->unique()->all();

                return in_array($storeA->id, $storeIds, true)
                    && ! in_array($storeB->id, $storeIds, true);
            });
    });

    it('redirects manual and audit routes when current_store_id is null', function (): void {
        $this->tenant->locations = true;
        $this->tenant->save();

        Store::query()->create([
            'name' => 'Second Overview Redirect Store '.uniqid(),
            'slug' => 'second-overview-redirect-store-'.uniqid(),
            'state' => 'IN',
        ]);

        $this->consultant->update(['current_store_id' => null]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.manual.isp.index'))
            ->assertRedirect(route('dealer.dashboard'));

        $this->actingAs($this->consultant)
            ->get(route('dealer.audit.osha.index'))
            ->assertRedirect(route('dealer.dashboard'));
    });

    it('allows manual and audit routes when current_store_id is set', function (): void {
        $this->tenant->locations = true;
        $this->tenant->save();

        $store = Store::query()->firstOrFail();
        $this->consultant->update(['current_store_id' => $store->id]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.manual.isp.index'))
            ->assertOk();

        $this->actingAs($this->consultant)
            ->get(route('dealer.audit.osha.index'))
            ->assertOk();
    });

    it('shows vendor records only for scoped stores plus global vendors', function (): void {
        $this->tenant->locations = true;
        $this->tenant->save();

        $storeA = Store::query()->firstOrFail();
        $storeB = Store::query()->create([
            'name' => 'Vendor Scope Store B '.uniqid(),
            'slug' => 'vendor-scope-store-b-'.uniqid(),
            'state' => 'IN',
        ]);

        $manager = User::query()->create([
            'name' => 'Vendor Scope Manager',
            'email' => 'vendor-scope-manager@test.com',
            'password' => bcrypt('password'),
            'current_store_id' => null,
        ]);
        $manager->assignRole('Manager');
        $manager->stores()->attach([$storeA->id]);

        $vendorAName = 'Vendor A';
        $vendorBName = 'Vendor B';
        $globalVendorName = 'Vendor Global';

        Vendor::query()->create([
            'name' => $vendorAName,
            'contact_name' => 'Contact A',
            'contact_email' => 'contact-a@test.com',
            'store_id' => $storeA->id,
        ]);

        Vendor::query()->create([
            'name' => $vendorBName,
            'contact_name' => 'Contact B',
            'contact_email' => 'contact-b@test.com',
            'store_id' => $storeB->id,
        ]);

        Vendor::query()->create([
            'name' => $globalVendorName,
            'contact_name' => 'Contact Global',
            'contact_email' => 'contact-global@test.com',
            'store_id' => null,
        ]);

        $this->actingAs($manager);

        Livewire::test(VendorIndex::class)
            ->assertOk()
            ->assertSee($vendorAName)
            ->assertSee($globalVendorName)
            ->assertDontSee($vendorBName);
    });
});
