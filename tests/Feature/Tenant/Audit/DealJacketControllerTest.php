<?php

declare(strict_types=1);

use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $this->store->id]);
});

/**
 * @return array{0: DealJacketGroup, 1: DealJacket}
 */
function makeGroupWithJacket(Store $store, User $owner): array
{
    $group = DealJacketGroup::query()->create([
        'uuid' => (string) Str::uuid(),
        'store_id' => $store->id,
        'completed' => false,
    ]);

    $jacket = DealJacket::query()->create([
        'uuid' => (string) Str::uuid(),
        'deal_jacket_group_id' => $group->id,
        'user_id' => $owner->id,
        'customer_name' => 'Cust '.uniqid(),
        'customer_deal_number' => 'D-'.uniqid(),
        'mileage' => 10000,
        'purchase_type' => 'finance',
        'vehicle_type' => 'new',
        'audit_date' => now()->subDay(),
        'date_of_deal_jacket' => now()->subDays(2),
        'responses' => [],
        'total_passed' => 0,
        'total_failed' => 0,
        'total_high_risk' => 0,
        'percentage' => 0,
    ]);

    return [$group, $jacket];
}

describe('authorization', function (): void {
    it('redirects guests from the index to login', function (): void {
        tenancy()->end();
        $this->tenant->run(function (): void {
            $this->get(route('dealer.audit.deal-jackets.index'))
                ->assertRedirect(route('dealer.login'));
        });
    });

    it('forbids the index for an Employee user', function (): void {
        $employee = User::query()->create([
            'name' => 'Bystander',
            'email' => 'bystander-'.uniqid().'@test-tenant.localhost',
            'password' => bcrypt('password'),
        ]);
        $employee->assignRole('Employee');
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->actingAs($employee)
            ->get(route('dealer.audit.deal-jackets.index'))
            ->assertForbidden();
    });

    it('allows the Consultant to view the index', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.audit.deal-jackets.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/audits/deal-jackets/Index')
                ->where('store.id', $this->store->id)
                ->has('groups')
                ->has('charts')
            );
    });
});

it('starts a new deal jacket group for the current store', function (): void {
    expect(DealJacketGroup::query()->count())->toBe(0);

    $this->actingAs($this->consultant)
        ->post(route('dealer.audit.deal-jackets.start'))
        ->assertRedirect();

    $group = DealJacketGroup::query()->sole();
    expect($group->store_id)->toBe($this->store->id)
        ->and($group->completed)->toBeFalse();
});

it('does not create a second group when one already exists for the current quarter', function (): void {
    DealJacketGroup::query()->create([
        'uuid' => (string) Str::uuid(),
        'store_id' => $this->store->id,
        'completed' => false,
    ]);

    $this->actingAs($this->consultant)
        ->post(route('dealer.audit.deal-jackets.start'))
        ->assertRedirect(route('dealer.audit.deal-jackets.index'));

    expect(DealJacketGroup::query()->count())->toBe(1);
});

it('marks a group complete', function (): void {
    [$group] = makeGroupWithJacket($this->store, $this->consultant);

    $this->actingAs($this->consultant)
        ->post(route('dealer.audit.deal-jackets.complete', $group->uuid))
        ->assertRedirect();

    expect($group->fresh()->completed)->toBeTrue();
});

it('deletes a group and redirects to the index', function (): void {
    [$group] = makeGroupWithJacket($this->store, $this->consultant);

    $this->actingAs($this->consultant)
        ->delete(route('dealer.audit.deal-jackets.destroy-group', $group->uuid))
        ->assertRedirect(route('dealer.audit.deal-jackets.index'));

    expect(DealJacketGroup::query()->find($group->id))->toBeNull();
});

it('deletes an individual jacket within a group', function (): void {
    [$group, $jacket] = makeGroupWithJacket($this->store, $this->consultant);

    $this->actingAs($this->consultant)
        ->delete(route('dealer.audit.deal-jackets.destroy', [$group->uuid, $jacket->uuid]))
        ->assertRedirect();

    expect(DealJacket::query()->find($jacket->id))->toBeNull();
    expect(DealJacketGroup::query()->find($group->id))->not->toBeNull();
});

it('returns 404 when looking up a group by an unknown uuid', function (): void {
    $this->actingAs($this->consultant)
        ->get(route('dealer.audit.deal-jackets.show', 'unknown-uuid'))
        ->assertNotFound();
});
