<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Employee\Invite as InviteComponent;
use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Department;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Facades\Queue;
use Livewire\Livewire;

describe('Invite slide-over component', function (): void {
    describe('validation failures', function (): void {
        it('requires a name', function (): void {
            $department = Department::query()->firstOrFail();

            Livewire::actingAs($this->consultant)
                ->test(InviteComponent::class)
                ->set('email', 'new-employee@test.com')
                ->set('department', (string) $department->id)
                ->set('role', 'Employee')
                ->call('sendInvite')
                ->assertHasErrors(['name' => 'required']);
        });

        it('requires an email', function (): void {
            $department = Department::query()->firstOrFail();

            Livewire::actingAs($this->consultant)
                ->test(InviteComponent::class)
                ->set('name', 'Test Employee')
                ->set('department', (string) $department->id)
                ->set('role', 'Employee')
                ->call('sendInvite')
                ->assertHasErrors(['email' => 'required']);
        });

        it('requires a valid email address', function (): void {
            $department = Department::query()->firstOrFail();

            Livewire::actingAs($this->consultant)
                ->test(InviteComponent::class)
                ->set('name', 'Test Employee')
                ->set('email', 'not-an-email')
                ->set('department', (string) $department->id)
                ->set('role', 'Employee')
                ->call('sendInvite')
                ->assertHasErrors(['email' => 'email']);
        });

        it('rejects an email already registered to a user', function (): void {
            $department = Department::query()->firstOrFail();
            $existingUser = User::factory()->create(['email' => 'existing-user-invite@test.com']);

            Livewire::actingAs($this->consultant)
                ->test(InviteComponent::class)
                ->set('name', 'Test Employee')
                ->set('email', $existingUser->email)
                ->set('department', (string) $department->id)
                ->set('role', 'Employee')
                ->call('sendInvite')
                ->assertHasErrors(['email' => 'unique']);
        });

        it('rejects an email already on an open invite', function (): void {
            $department = Department::query()->firstOrFail();

            Invite::query()->create([
                'name' => 'Pending Invite',
                'email' => 'pending-invite-comp@test.com',
                'roles' => ['Employee'],
                'stores' => [],
            ]);

            Livewire::actingAs($this->consultant)
                ->test(InviteComponent::class)
                ->set('name', 'Test Employee')
                ->set('email', 'pending-invite-comp@test.com')
                ->set('department', (string) $department->id)
                ->set('role', 'Employee')
                ->call('sendInvite')
                ->assertHasErrors(['email' => 'unique']);
        });

        it('requires a department', function (): void {
            Livewire::actingAs($this->consultant)
                ->test(InviteComponent::class)
                ->set('name', 'Test Employee')
                ->set('email', 'no-dept-invite@test.com')
                ->set('role', 'Employee')
                ->call('sendInvite')
                ->assertHasErrors(['department' => 'required']);
        });

        it('requires a valid department', function (): void {
            Livewire::actingAs($this->consultant)
                ->test(InviteComponent::class)
                ->set('name', 'Test Employee')
                ->set('email', 'bad-dept-invite@test.com')
                ->set('department', '99999')
                ->set('role', 'Employee')
                ->call('sendInvite')
                ->assertHasErrors(['department']);
        });

        it('requires a role', function (): void {
            $department = Department::query()->firstOrFail();

            Livewire::actingAs($this->consultant)
                ->test(InviteComponent::class)
                ->set('name', 'Test Employee')
                ->set('email', 'no-role-invite@test.com')
                ->set('department', (string) $department->id)
                ->call('sendInvite')
                ->assertHasErrors(['role' => 'required']);
        });

        it('requires stores when multiple stores exist', function (): void {
            $department = Department::query()->firstOrFail();

            Store::query()->create([
                'name' => 'Second Invite Store '.uniqid(),
                'address' => '2 Main St',
                'city' => 'Nashville',
                'state' => 'TN',
                'postal_code' => '37202',
                'phone' => '615-555-0102',
                'website' => 'https://second-invite-store.test',
            ]);

            Livewire::actingAs($this->consultant)
                ->test(InviteComponent::class)
                ->set('name', 'Test Employee')
                ->set('email', 'no-stores-invite@test.com')
                ->set('department', (string) $department->id)
                ->set('role', 'Employee')
                ->set('stores', [])
                ->call('sendInvite')
                ->assertHasErrors(['stores']);
        });

        it('requires a primary store when multiple stores are selected', function (): void {
            $department = Department::query()->firstOrFail();
            $storeA = Store::query()->firstOrFail();
            $storeB = Store::query()->create([
                'name' => 'Primary Required Store '.uniqid(),
                'address' => '3 Main St',
                'city' => 'Nashville',
                'state' => 'TN',
                'postal_code' => '37203',
                'phone' => '615-555-0103',
                'website' => 'https://primary-required-store.test',
            ]);

            Livewire::actingAs($this->consultant)
                ->test(InviteComponent::class)
                ->set('name', 'Test Employee')
                ->set('email', 'no-primary-invite@test.com')
                ->set('department', (string) $department->id)
                ->set('role', 'Employee')
                ->set('stores', [(string) $storeA->id, (string) $storeB->id])
                ->set('primaryStoreId', null)
                ->call('sendInvite')
                ->assertHasErrors(['primaryStoreId' => 'required']);
        });
    });

    describe('successful submission', function (): void {
        it('sends invite for single-store tenant without requiring store selection', function (): void {
            Queue::fake();

            $department = Department::query()->firstOrFail();
            $store = Store::query()->firstOrFail();

            Livewire::actingAs($this->consultant)
                ->test(InviteComponent::class)
                ->set('name', 'New Invite Employee')
                ->set('email', 'new-invite-employee@test.com')
                ->set('department', (string) $department->id)
                ->set('role', 'Employee')
                ->call('sendInvite')
                ->assertHasNoErrors();

            $invite = Invite::query()->where('email', 'new-invite-employee@test.com')->firstOrFail();

            expect($invite->stores)->toBe([$store->id])
                ->and($invite->roles)->toBe(['Employee'])
                ->and($invite->invitation_token)->toHaveLength(32)
                ->and($invite->primary_store_id)->toBeNull();

            Queue::assertPushed(SendQueueEmailJob::class);
        });

        it('saves primary store id on invite when multiple stores are selected', function (): void {
            Queue::fake();

            $department = Department::query()->firstOrFail();
            $storeA = Store::query()->firstOrFail();
            $storeB = Store::query()->create([
                'name' => 'Primary Save Store '.uniqid(),
                'address' => '4 Main St',
                'city' => 'Nashville',
                'state' => 'TN',
                'postal_code' => '37204',
                'phone' => '615-555-0104',
                'website' => 'https://primary-save-store.test',
            ]);

            Livewire::actingAs($this->consultant)
                ->test(InviteComponent::class)
                ->set('name', 'Multi Store Invite Employee')
                ->set('email', 'multi-store-invite-employee@test.com')
                ->set('department', (string) $department->id)
                ->set('role', 'Employee')
                ->set('stores', [(string) $storeA->id, (string) $storeB->id])
                ->set('primaryStoreId', $storeA->id)
                ->call('sendInvite')
                ->assertHasNoErrors();

            $invite = Invite::query()->where('email', 'multi-store-invite-employee@test.com')->firstOrFail();

            expect($invite->primary_store_id)->toBe($storeA->id)
                ->and($invite->stores)->toContain($storeA->id)
                ->and($invite->stores)->toContain($storeB->id);

            Queue::assertPushed(SendQueueEmailJob::class);
        });

        it('does not save primary store id when only one store is selected', function (): void {
            Queue::fake();

            $department = Department::query()->firstOrFail();
            $storeA = Store::query()->firstOrFail();
            $storeB = Store::query()->create([
                'name' => 'No Primary Store '.uniqid(),
                'address' => '5 Main St',
                'city' => 'Nashville',
                'state' => 'TN',
                'postal_code' => '37205',
                'phone' => '615-555-0105',
                'website' => 'https://no-primary-store.test',
            ]);

            Livewire::actingAs($this->consultant)
                ->test(InviteComponent::class)
                ->set('name', 'Single Store Invite Employee')
                ->set('email', 'single-store-invite-employee@test.com')
                ->set('department', (string) $department->id)
                ->set('role', 'Employee')
                ->set('stores', [(string) $storeA->id])
                ->call('sendInvite')
                ->assertHasNoErrors();

            $invite = Invite::query()->where('email', 'single-store-invite-employee@test.com')->firstOrFail();

            expect($invite->primary_store_id)->toBeNull();
        });
    });
});
