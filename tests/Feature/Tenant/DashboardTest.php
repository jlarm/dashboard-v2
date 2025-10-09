<?php

declare(strict_types=1);

use App\Models\Dealer\Store;

beforeEach(fn () => setupCentralDatabase());
afterEach(fn () => teardownTenants());

it('can access dashboard when logged in', function () {
    [$dealership, $consultant] = createDealershipTenant();

    $dealership->run(function () use ($consultant) {
        $store = Store::create([
            'name' => 'Acme',
            'slug' => 'acme',
        ]);

        $this->actingAs($consultant)
            ->get(route('dealer.dashboard'))
            ->assertOk();
    });
});
