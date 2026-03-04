<?php

declare(strict_types=1);

use App\Http\Livewire\Central\Dealership\Create as DealershipCreateModal;
use App\Models\Dealer\Store;
use App\Models\Dealership;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->seed(RoleAndPermissionSeeder::class);
    app()[PermissionRegistrar::class]->forgetCachedPermissions();
});

it('creates dealership from a consultant with only name and provisions super-admins plus creator', function (): void {
    $creator = User::query()->firstOrCreate(
        ['email' => 'central.consultant@example.com'],
        ['name' => 'Central Consultant', 'phone' => '1111111111', 'email_verified_at' => now(), 'password' => bcrypt('password')]
    );
    $creator->assignRole('Consultant');

    $superAdminA = User::query()->firstOrCreate(
        ['email' => 'jlohr@autorisknow.com'],
        ['name' => 'Joe Lohr', 'phone' => '2222222222', 'email_verified_at' => now(), 'password' => bcrypt('password')]
    );
    $superAdminA->assignRole('super-admin');

    $superAdminB = User::query()->firstOrCreate(
        ['email' => 'tdortch@autorisknow.com'],
        ['name' => 'Terry Dortch', 'phone' => '3333333333', 'email_verified_at' => now(), 'password' => bcrypt('password')]
    );
    $superAdminB->assignRole('super-admin');

    $otherConsultant = User::query()->firstOrCreate(
        ['email' => 'other.consultant@example.com'],
        ['name' => 'Other Consultant', 'phone' => '4444444444', 'email_verified_at' => now(), 'password' => bcrypt('password')]
    );
    $otherConsultant->assignRole('Consultant');

    $dealershipName = 'Dealership '.Str::upper(Str::random(6));

    $response = $this
        ->actingAs($creator)
        ->post(route('dealerships.store'), [
            'name' => $dealershipName,
        ]);

    $response->assertRedirect(route('dealerships.index'));

    $dealership = Dealership::query()
        ->where('name', $dealershipName)
        ->first();

    expect($dealership)->toBeInstanceOf(Dealership::class);

    if (! $dealership instanceof Dealership) {
        return;
    }

    expect($dealership->domain)->toStartWith(Str::slug($dealershipName).'.');

    $centralAttachedEmails = $dealership->users()
        ->orderBy('email')
        ->pluck('users.email')
        ->all();

    expect($centralAttachedEmails)->toContain('central.consultant@example.com');
    expect($centralAttachedEmails)->toContain('jlohr@autorisknow.com');
    expect($centralAttachedEmails)->toContain('tdortch@autorisknow.com');
    expect($centralAttachedEmails)->not->toContain('other.consultant@example.com');

    try {
        $summary = $dealership->run(function (): array {
            $tenantUsers = User::query()
                ->whereIn('email', [
                    'central.consultant@example.com',
                    'jlohr@autorisknow.com',
                    'tdortch@autorisknow.com',
                ])
                ->with('stores:id', 'roles:id,name')
                ->get();

            return [
                'store_count' => Store::query()->count(),
                'users' => $tenantUsers->mapWithKeys(fn (User $user): array => [
                    $user->email => [
                        'roles' => $user->roles->pluck('name')->all(),
                        'stores' => $user->stores->pluck('id')->map(static fn ($id): int => (int) $id)->all(),
                        'current_store_id' => $user->current_store_id,
                    ],
                ])->all(),
            ];
        });

        expect($summary['store_count'])->toBe(0);
        expect($summary['users']['central.consultant@example.com']['roles'])->toContain('Consultant');
        expect($summary['users']['jlohr@autorisknow.com']['roles'])->toContain('super-admin');
        expect($summary['users']['tdortch@autorisknow.com']['roles'])->toContain('super-admin');

        expect($summary['users']['central.consultant@example.com']['stores'])->toBe([]);
        expect($summary['users']['jlohr@autorisknow.com']['stores'])->toBe([]);
        expect($summary['users']['tdortch@autorisknow.com']['stores'])->toBe([]);

        expect($summary['users']['central.consultant@example.com']['current_store_id'])->toBeNull();
        expect($summary['users']['jlohr@autorisknow.com']['current_store_id'])->toBeNull();
        expect($summary['users']['tdortch@autorisknow.com']['current_store_id'])->toBeNull();
    } finally {
        $dealership->users()->detach();
        $dealership->forceDelete();
    }
});

it('creates dealership from a super-admin and does not add unrelated consultants', function (): void {
    $creator = User::query()->firstOrCreate(
        ['email' => 'mbacker@autorisknow.com'],
        ['name' => 'Mike Backer', 'phone' => '5555555555', 'email_verified_at' => now(), 'password' => bcrypt('password')]
    );
    $creator->assignRole('super-admin');

    $superAdmin = User::query()->firstOrCreate(
        ['email' => 'jlohr@autorisknow.com'],
        ['name' => 'Joe Lohr', 'phone' => '6666666666', 'email_verified_at' => now(), 'password' => bcrypt('password')]
    );
    $superAdmin->assignRole('super-admin');

    $consultant = User::query()->firstOrCreate(
        ['email' => 'central.consultant@example.com'],
        ['name' => 'Central Consultant', 'phone' => '7777777777', 'email_verified_at' => now(), 'password' => bcrypt('password')]
    );
    $consultant->assignRole('Consultant');

    $dealershipName = 'Dealership '.Str::upper(Str::random(6));

    $response = $this
        ->actingAs($creator)
        ->post(route('dealerships.store'), [
            'name' => $dealershipName,
        ]);

    $response->assertRedirect(route('dealerships.index'));

    $dealership = Dealership::query()
        ->where('name', $dealershipName)
        ->first();

    expect($dealership)->toBeInstanceOf(Dealership::class);

    if (! $dealership instanceof Dealership) {
        return;
    }

    $centralAttachedEmails = $dealership->users()
        ->orderBy('email')
        ->pluck('users.email')
        ->all();

    expect($centralAttachedEmails)->toContain('mbacker@autorisknow.com');
    expect($centralAttachedEmails)->toContain('jlohr@autorisknow.com');
    expect($centralAttachedEmails)->not->toContain('central.consultant@example.com');

    try {
        $summary = $dealership->run(fn (): array => [
            'tenant_emails' => User::query()->orderBy('email')->pluck('email')->all(),
            'store_count' => Store::query()->count(),
        ]);

        expect($summary['tenant_emails'])->toContain('mbacker@autorisknow.com');
        expect($summary['tenant_emails'])->toContain('jlohr@autorisknow.com');
        expect($summary['tenant_emails'])->not->toContain('central.consultant@example.com');
        expect($summary['store_count'])->toBe(0);
    } finally {
        $dealership->users()->detach();
        $dealership->forceDelete();
    }
});

it('generates a unique domain from the dealership name', function (): void {
    $creator = User::query()->firstOrCreate(
        ['email' => 'central.consultant@example.com'],
        ['name' => 'Central Consultant', 'phone' => '8888888888', 'email_verified_at' => now(), 'password' => bcrypt('password')]
    );
    $creator->assignRole('Consultant');

    $superAdmin = User::query()->firstOrCreate(
        ['email' => 'jlohr@autorisknow.com'],
        ['name' => 'Joe Lohr', 'phone' => '9999999999', 'email_verified_at' => now(), 'password' => bcrypt('password')]
    );
    $superAdmin->assignRole('super-admin');

    $firstName = 'Acme Auto Group';
    $secondName = 'Acme  Auto Group';

    $this->actingAs($creator)->post(route('dealerships.store'), ['name' => $firstName])->assertRedirect(route('dealerships.index'));
    $this->actingAs($creator)->post(route('dealerships.store'), ['name' => $secondName])->assertRedirect(route('dealerships.index'));

    $first = Dealership::query()->where('name', $firstName)->firstOrFail();
    $second = Dealership::query()->where('name', $secondName)->firstOrFail();

    expect($first->domain)->toBe(Str::slug($firstName).'.'.config('tenancy.central_domains.0'));
    expect($second->domain)->toBe(Str::slug($firstName).'-2.'.config('tenancy.central_domains.0'));

    $first->users()->detach();
    $second->users()->detach();
    $first->forceDelete();
    $second->forceDelete();
});

it('creates a dealership from the modal with name only', function (): void {
    $creator = User::query()->firstOrCreate(
        ['email' => 'central.consultant@example.com'],
        ['name' => 'Central Consultant', 'phone' => '1010101010', 'email_verified_at' => now(), 'password' => bcrypt('password')]
    );
    $creator->assignRole('Consultant');

    $superAdmin = User::query()->firstOrCreate(
        ['email' => 'jlohr@autorisknow.com'],
        ['name' => 'Joe Lohr', 'phone' => '1212121212', 'email_verified_at' => now(), 'password' => bcrypt('password')]
    );
    $superAdmin->assignRole('super-admin');

    $this->actingAs($creator);

    Livewire::test(DealershipCreateModal::class)
        ->set('name', 'Modal Created Dealership')
        ->call('createDealership')
        ->assertHasNoErrors();

    $dealership = Dealership::query()->where('name', 'Modal Created Dealership')->firstOrFail();
    $storeCount = $dealership->run(fn (): int => Store::query()->count());

    expect($storeCount)->toBe(0);

    $dealership->users()->detach();
    $dealership->forceDelete();
});
