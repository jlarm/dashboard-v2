<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Home\BodyShopStats;
use App\Http\Livewire\Dealer\Home\DealJacketStats;
use App\Http\Livewire\Dealer\Home\GlbaStats;
use App\Http\Livewire\Dealer\Home\Manuals;
use App\Http\Livewire\Dealer\Home\OshaStats;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Store;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->tenant->update(['locations' => true]);

    $this->primaryStore = Store::query()->firstOrFail();
    $this->scopedStore = Store::query()->create([
        'name' => 'Scoped Store '.uniqid(),
        'slug' => 'scoped-store-'.uniqid(),
    ]);

    $this->manager = User::query()->create([
        'name' => 'Scoped Widget Manager',
        'email' => 'scoped-widget-manager@test.com',
        'password' => bcrypt('password'),
        'current_store_id' => null,
    ]);
    $this->manager->assignRole('Manager');
    $this->manager->stores()->attach($this->scopedStore->id);

    $this->actingAs($this->manager);

    app()->instance('currentStore', null);
    app()->forgetInstance('currentStoreModel');
    app()->instance('accessibleStoreIds', collect([$this->scopedStore->id]));
    app()->instance('scopedStoreIds', collect([$this->scopedStore->id]));
});

it('uses the scoped store for audit stat widgets when currentStoreModel is unavailable', function (string $componentClass, string $auditModelClass): void {
    $auditModelClass::query()->create([
        'uuid' => (string) str()->uuid(),
        'user_id' => $this->manager->id,
        'store_id' => $this->primaryStore->id,
        'date' => now()->subDay()->toDateString(),
        'grade' => 'A',
    ]);

    $auditModelClass::query()->create([
        'uuid' => (string) str()->uuid(),
        'user_id' => $this->manager->id,
        'store_id' => $this->scopedStore->id,
        'date' => now()->toDateString(),
        'grade' => 'C',
    ]);

    $component = Livewire::test($componentClass);

    expect($component->instance()->store?->id)->toBe($this->scopedStore->id)
        ->and($component->instance()->rating())->toBe('C');
})->with([
    [OshaStats::class, OshaViolationAudit::class],
    [BodyShopStats::class, BodyShopViolationAudit::class],
    [GlbaStats::class, GlbaViolationAudit::class],
]);

it('uses the scoped store for deal jacket stats when currentStoreModel is unavailable', function (): void {
    $primaryGroup = DealJacketGroup::factory()->create([
        'store_id' => $this->primaryStore->id,
        'completed' => true,
    ]);

    DealJacket::query()->create([
        'uuid' => (string) str()->uuid(),
        'deal_jacket_group_id' => $primaryGroup->id,
        'audit_date' => now()->subDay(),
        'date_of_deal_jacket' => now()->subDays(2),
        'customer_name' => 'Primary Customer',
        'customer_deal_number' => 'PRIMARY-1',
        'user_id' => $this->manager->id,
        'mileage' => 1000,
        'purchase_type' => 'cash',
        'vehicle_type' => 'used',
        'responses' => [],
        'total_passed' => 2,
        'total_failed' => 0,
        'total_high_risk' => 0,
        'percentage' => 100,
    ]);

    $scopedGroup = DealJacketGroup::factory()->create([
        'store_id' => $this->scopedStore->id,
        'completed' => true,
    ]);

    DealJacket::query()->create([
        'uuid' => (string) str()->uuid(),
        'deal_jacket_group_id' => $scopedGroup->id,
        'audit_date' => now(),
        'date_of_deal_jacket' => now()->subDay(),
        'customer_name' => 'Scoped Customer',
        'customer_deal_number' => 'SCOPED-1',
        'user_id' => $this->manager->id,
        'mileage' => 2000,
        'purchase_type' => 'finance',
        'vehicle_type' => 'new',
        'responses' => [],
        'total_passed' => 0,
        'total_failed' => 2,
        'total_high_risk' => 1,
        'percentage' => 0,
    ]);

    $component = Livewire::test(DealJacketStats::class);

    expect($component->instance()->store?->id)->toBe($this->scopedStore->id)
        ->and($component->instance()->rating())->toBe('F');
});

it('uses the scoped store for manuals when currentStoreModel is unavailable', function (): void {
    Isp::query()->create([
        'store_id' => $this->scopedStore->id,
        'user_id' => $this->manager->id,
    ]);

    $component = Livewire::test(Manuals::class);

    expect($component->instance()->store?->id)->toBe($this->scopedStore->id);

    $component->assertSee('Active');
});
