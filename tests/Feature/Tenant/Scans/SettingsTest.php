<?php

declare(strict_types=1);

use App\Models\Dealer\Cyrisma;
use App\Models\Dealer\Store;
use App\Services\CyrismaService;

beforeEach(function (): void {
    $this->store = Store::query()->first();
    app()->instance('currentStore', $this->store->id);
    app()->instance('currentStoreModel', $this->store);
});

describe('GET scans/settings', function (): void {
    it('renders the Inertia Settings page with current settings', function (): void {
        Cyrisma::query()->create([
            'store_id' => $this->store->id,
            'short_name' => 'short',
            'instance_id' => 'instance-123',
            'instance_url' => 'acme.cyrisma.com',
        ]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.settings'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/scans/Settings')
                ->where('settings.store_id', $this->store->id)
                ->where('settings.instance_id', 'acme')
                ->where('settings.is_connected', true));
    });

    it('shows null instance_id when no Cyrisma is configured', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.settings'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/scans/Settings')
                ->where('settings.instance_id', null)
                ->where('settings.is_connected', false));
    });

});

describe('PUT scans/settings', function (): void {
    it('creates a Cyrisma record when an instance match is found', function (): void {
        $cyrisma = test()->mock(CyrismaService::class);
        $cyrisma->shouldReceive('getAllInstances')->andReturn([
            ['url' => 'acme.cyrisma.com', 'short_name' => 'acme', 'instance_id' => 'instance-xyz'],
        ]);

        $this->actingAs($this->consultant)
            ->put(route('dealer.scan.settings.update'), ['instance_id' => 'acme'])
            ->assertRedirect();

        expect(Cyrisma::query()->where('store_id', $this->store->id)->first())
            ->not->toBeNull()
            ->short_name->toBe('acme')
            ->instance_id->toBe('instance-xyz')
            ->instance_url->toBe('acme.cyrisma.com');
    });

    it('updates an existing Cyrisma record', function (): void {
        Cyrisma::query()->create([
            'store_id' => $this->store->id,
            'short_name' => 'old',
            'instance_id' => 'old-id',
            'instance_url' => 'old.cyrisma.com',
        ]);

        $cyrisma = test()->mock(CyrismaService::class);
        $cyrisma->shouldReceive('getAllInstances')->andReturn([
            ['url' => 'new.cyrisma.com', 'short_name' => 'new', 'instance_id' => 'new-id'],
        ]);

        $this->actingAs($this->consultant)
            ->put(route('dealer.scan.settings.update'), ['instance_id' => 'new'])
            ->assertRedirect();

        expect(Cyrisma::query()->where('store_id', $this->store->id)->first())
            ->short_name->toBe('new')
            ->instance_id->toBe('new-id')
            ->instance_url->toBe('new.cyrisma.com');
    });

    it('returns a validation error when no matching instance exists', function (): void {
        $cyrisma = test()->mock(CyrismaService::class);
        $cyrisma->shouldReceive('getAllInstances')->andReturn([]);

        $this->actingAs($this->consultant)
            ->from(route('dealer.scan.settings'))
            ->put(route('dealer.scan.settings.update'), ['instance_id' => 'missing'])
            ->assertSessionHasErrors('instance_id');

        expect(Cyrisma::query()->where('store_id', $this->store->id)->exists())->toBeFalse();
    });

    it('rejects a missing instance_id', function (): void {
        $this->actingAs($this->consultant)
            ->from(route('dealer.scan.settings'))
            ->put(route('dealer.scan.settings.update'), [])
            ->assertSessionHasErrors('instance_id');
    });
});
