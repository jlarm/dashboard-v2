<?php

declare(strict_types=1);

use App\Models\Dealer\Cyrisma;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Policies\CyrismaPolicy;
use Spatie\Permission\PermissionRegistrar;

function makeCyrismaPolicyUser(string $role, Store $store): User
{
    $user = User::query()->create([
        'name' => "{$role} User",
        'email' => str($role)->slug()->append('-', uniqid(), '@test.com')->toString(),
        'password' => bcrypt('password'),
    ]);

    $user->assignRole($role);
    $user->stores()->attach($store->id);
    $user->update(['current_store_id' => $store->id]);

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    return $user;
}

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();
    $this->cyrisma = Cyrisma::query()->create([
        'store_id' => $this->store->id,
        'short_name' => 'test-instance',
        'instance_id' => 'instance-123',
        'instance_url' => 'test.cyrisma.com',
    ]);
    $this->policy = new CyrismaPolicy();
});

dataset('managerGroupReadOnlyRoles', [
    'Owner',
    'CFO',
    'GM',
    'GSM',
    'Qualified Individual',
    'Manager',
]);

it('allows manager-group roles to view cyrisma settings but not mutate them', function (string $role): void {
    $user = makeCyrismaPolicyUser($role, $this->store);

    expect($this->policy->viewAny($user))->toBeTrue()
        ->and($this->policy->create($user))->toBeFalse()
        ->and($this->policy->update($user, $this->cyrisma))->toBeFalse()
        ->and($this->policy->delete($user, $this->cyrisma))->toBeFalse();
})->with('managerGroupReadOnlyRoles');

it('allows consultants to view and mutate cyrisma settings', function (): void {
    $this->consultant->stores()->sync([$this->store->id]);
    $this->consultant->update(['current_store_id' => $this->store->id]);

    expect($this->policy->viewAny($this->consultant))->toBeTrue()
        ->and($this->policy->create($this->consultant))->toBeTrue()
        ->and($this->policy->update($this->consultant, $this->cyrisma))->toBeTrue()
        ->and($this->policy->delete($this->consultant, $this->cyrisma))->toBeTrue();
});

it('allows super-admins to view and mutate cyrisma settings', function (): void {
    $user = makeCyrismaPolicyUser('super-admin', $this->store);

    expect($this->policy->viewAny($user))->toBeTrue()
        ->and($this->policy->create($user))->toBeTrue()
        ->and($this->policy->update($user, $this->cyrisma))->toBeTrue()
        ->and($this->policy->delete($user, $this->cyrisma))->toBeTrue();
});
