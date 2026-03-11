<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Employee\OpenInvites;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use App\Models\Department;
use App\Models\User;
use Livewire\Livewire;

describe('employee open invites store scope', function (): void {
    it('filters invites by current_store_id for regular users', function (): void {
        $this->tenant->locations = true;
        $this->tenant->save();

        $department = Department::query()->create([
            'name' => 'Open Invites Department '.uniqid(),
            'slug' => 'open-invites-department-'.uniqid(),
        ]);

        $storeA = Store::query()->firstOrFail();
        $storeB = Store::query()->create([
            'name' => 'Open Invites Store B '.uniqid(),
            'slug' => 'open-invites-store-b-'.uniqid(),
            'state' => 'IN',
        ]);

        $manager = User::query()->create([
            'name' => 'Open Invites Manager',
            'email' => 'open-invites-manager@test.com',
            'password' => bcrypt('password'),
            'department_id' => $department->id,
            'current_store_id' => $storeA->id,
        ]);
        $manager->assignRole('Manager');
        $manager->stores()->attach([$storeA->id, $storeB->id]);

        $inviteInStoreA = Invite::query()->create([
            'name' => 'Invite Store A',
            'email' => 'invite-store-a@test.com',
            'stores' => [$storeA->id],
            'department_id' => $department->id,
            'user_id' => $this->consultant->id,
            'roles' => ['Employee'],
            'invitation_token' => 'invite-store-a-token-123456',
        ]);

        $inviteInStoreB = Invite::query()->create([
            'name' => 'Invite Store B',
            'email' => 'invite-store-b@test.com',
            'stores' => [$storeB->id],
            'department_id' => $department->id,
            'user_id' => $this->consultant->id,
            'roles' => ['Employee'],
            'invitation_token' => 'invite-store-b-token-123456',
        ]);

        $this->actingAs($manager);

        Livewire::test(OpenInvites::class)
            ->assertOk()
            ->assertViewHas('invites', function ($invites) use ($inviteInStoreA, $inviteInStoreB): bool {
                $inviteIds = collect($invites->items())->pluck('id')->all();

                return in_array($inviteInStoreA->id, $inviteIds, true)
                    && ! in_array($inviteInStoreB->id, $inviteIds, true);
            });
    });

    it('shows invites from all assigned stores when current_store_id is null', function (): void {
        $this->tenant->locations = true;
        $this->tenant->save();

        $department = Department::query()->create([
            'name' => 'Overview Invites Department '.uniqid(),
            'slug' => 'overview-invites-department-'.uniqid(),
        ]);

        $storeA = Store::query()->firstOrFail();
        $storeB = Store::query()->create([
            'name' => 'Overview Invites Store B '.uniqid(),
            'slug' => 'overview-invites-store-b-'.uniqid(),
            'state' => 'IN',
        ]);

        $manager = User::query()->create([
            'name' => 'Overview Invites Manager',
            'email' => 'overview-invites-manager@test.com',
            'password' => bcrypt('password'),
            'department_id' => $department->id,
            'current_store_id' => null,
        ]);
        $manager->assignRole('Manager');
        $manager->stores()->attach([$storeA->id, $storeB->id]);

        $inviteInStoreA = Invite::query()->create([
            'name' => 'Overview Invite Store A',
            'email' => 'overview-invite-store-a@test.com',
            'stores' => [$storeA->id],
            'department_id' => $department->id,
            'user_id' => $this->consultant->id,
            'roles' => ['Employee'],
            'invitation_token' => 'overview-store-a-token-12345',
        ]);

        $inviteInStoreB = Invite::query()->create([
            'name' => 'Overview Invite Store B',
            'email' => 'overview-invite-store-b@test.com',
            'stores' => [$storeB->id],
            'department_id' => $department->id,
            'user_id' => $this->consultant->id,
            'roles' => ['Employee'],
            'invitation_token' => 'overview-store-b-token-12345',
        ]);

        $this->actingAs($manager);

        Livewire::test(OpenInvites::class)
            ->assertOk()
            ->assertViewHas('invites', function ($invites) use ($inviteInStoreA, $inviteInStoreB): bool {
                $inviteIds = collect($invites->items())->pluck('id')->all();

                return in_array($inviteInStoreA->id, $inviteIds, true)
                    && in_array($inviteInStoreB->id, $inviteIds, true);
            });
    });

    it('renders invites with nested store arrays without crashing', function (): void {
        $this->tenant->locations = true;
        $this->tenant->save();

        $department = Department::query()->create([
            'name' => 'Nested Invite Department '.uniqid(),
            'slug' => 'nested-invite-department-'.uniqid(),
        ]);

        $storeA = Store::query()->firstOrFail();
        $storeB = Store::query()->create([
            'name' => 'Nested Invite Store B '.uniqid(),
            'slug' => 'nested-invite-store-b-'.uniqid(),
            'state' => 'IN',
        ]);

        Invite::query()->create([
            'name' => 'Nested Invite',
            'email' => 'nested-invite@test.com',
            'stores' => [[$storeA->id, $storeB->id]],
            'department_id' => $department->id,
            'user_id' => $this->consultant->id,
            'roles' => ['Employee'],
            'invitation_token' => 'nested-invite-token-123456',
        ]);

        $this->actingAs($this->consultant);

        Livewire::test(OpenInvites::class)
            ->assertOk()
            ->assertSee('Nested Invite')
            ->assertSee($storeA->name)
            ->assertSee($storeB->name);
    });
});
