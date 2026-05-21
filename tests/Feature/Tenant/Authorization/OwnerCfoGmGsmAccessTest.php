<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

function makeQiGroupUser(string $role, Store $store): User
{
    $emailSlug = str($role)->lower()->replace(' ', '-');

    $user = User::query()->create([
        'name' => $role.' Access User',
        'email' => "{$emailSlug}@test.com",
        'password' => bcrypt('password'),
        'current_store_id' => $store->id,
    ]);

    $user->assignRole($role);
    $user->stores()->sync([$store->id]);

    return $user;
}

describe('owner, cfo, gm, and gsm access', function (): void {
    it('allows QI-group routes', function (string $role): void {
        $user = makeQiGroupUser($role, $this->store);

        $this->actingAs($user)
            ->get(route('dealer.employees.deleted'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('dealer.manual.isp.index'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('dealer.dealer.settings'))
            ->assertOk();
    })->with([
        'Owner' => 'Owner',
        'CFO' => 'CFO',
        'GM' => 'GM',
        'GSM' => 'GSM',
    ]);

    it('forbids consultant-only routes', function (string $role): void {
        $user = makeQiGroupUser($role, $this->store);

        $this->actingAs($user)
            ->get(route('dealer.locations.index'))
            ->assertForbidden();
    })->with([
        'Owner' => 'Owner',
        'CFO' => 'CFO',
        'GM' => 'GM',
        'GSM' => 'GSM',
    ]);
});
