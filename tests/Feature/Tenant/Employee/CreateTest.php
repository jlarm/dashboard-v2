<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Employee\Create as EmployeeCreate;
use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Department;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Facades\Queue;
use Livewire\Livewire;

describe('employee create component', function (): void {
    it('requires a name', function (): void {
        $department = Department::query()->firstOrFail();
        $store = Store::query()->firstOrFail();

        Livewire::actingAs($this->consultant)
            ->test(EmployeeCreate::class)
            ->set('email', 'no-name@test.com')
            ->set('department', $department->id)
            ->set('role', 'Employee')
            ->set('dealers', [(string) $store->id])
            ->call('submit')
            ->assertHasErrors(['name' => 'required']);
    });

    it('requires a valid email address', function (): void {
        $department = Department::query()->firstOrFail();
        $store = Store::query()->firstOrFail();

        Livewire::actingAs($this->consultant)
            ->test(EmployeeCreate::class)
            ->set('name', 'Test Employee')
            ->set('email', 'not-an-email')
            ->set('department', $department->id)
            ->set('role', 'Employee')
            ->set('dealers', [(string) $store->id])
            ->call('submit')
            ->assertHasErrors(['email' => 'email']);
    });

    it('rejects an email already registered to a user', function (): void {
        $department = Department::query()->firstOrFail();
        $store = Store::query()->firstOrFail();
        $existingUser = User::factory()->create(['email' => 'existing-create@test.com']);

        Livewire::actingAs($this->consultant)
            ->test(EmployeeCreate::class)
            ->set('name', 'Test Employee')
            ->set('email', $existingUser->email)
            ->set('department', $department->id)
            ->set('role', 'Employee')
            ->set('dealers', [(string) $store->id])
            ->call('submit')
            ->assertHasErrors(['email' => 'unique']);
    });

    it('requires a department', function (): void {
        $store = Store::query()->firstOrFail();

        Livewire::actingAs($this->consultant)
            ->test(EmployeeCreate::class)
            ->set('name', 'Test Employee')
            ->set('email', 'no-dept-create@test.com')
            ->set('role', 'Employee')
            ->set('dealers', [(string) $store->id])
            ->call('submit')
            ->assertHasErrors(['department' => 'required']);
    });

    it('requires a primary store when multiple stores are selected', function (): void {
        $department = Department::query()->firstOrFail();

        $storeA = Store::query()->firstOrFail();
        $storeB = Store::query()->create([
            'name' => 'Primary Required Create Store '.uniqid(),
            'address' => '3 Main St',
            'city' => 'Nashville',
            'state' => 'TN',
            'postal_code' => '37203',
            'phone' => '615-555-0103',
            'website' => 'https://primary-required-create-store.test',
        ]);

        Livewire::actingAs($this->consultant)
            ->test(EmployeeCreate::class)
            ->set('name', 'Test Employee')
            ->set('email', 'no-primary-create@test.com')
            ->set('department', $department->id)
            ->set('role', 'Employee')
            ->set('dealers', [(string) $storeA->id, (string) $storeB->id])
            ->set('primaryStoreId')
            ->call('submit')
            ->assertHasErrors(['primaryStoreId' => 'required']);
    });

    it('saves primary store id on invite when multiple stores are selected', function (): void {
        Queue::fake();

        $department = Department::query()->firstOrFail();
        $storeA = Store::query()->firstOrFail();
        $storeB = Store::query()->create([
            'name' => 'Primary Save Create Store '.uniqid(),
            'address' => '4 Main St',
            'city' => 'Nashville',
            'state' => 'TN',
            'postal_code' => '37204',
            'phone' => '615-555-0104',
            'website' => 'https://primary-save-create-store.test',
        ]);

        Livewire::actingAs($this->consultant)
            ->test(EmployeeCreate::class)
            ->set('name', 'Multi Store Create Employee')
            ->set('email', 'multi-store-create-employee@test.com')
            ->set('department', $department->id)
            ->set('role', 'Employee')
            ->set('dealers', [(string) $storeA->id, (string) $storeB->id])
            ->set('primaryStoreId', $storeA->id)
            ->call('submit')
            ->assertRedirect(route('dealer.employees.index'));

        $invite = Invite::query()->where('email', 'multi-store-create-employee@test.com')->firstOrFail();

        expect($invite->primary_store_id)->toBe($storeA->id);
    });

    it('requires exactly one role selection via role dropdown', function (): void {
        $department = Department::query()->create([
            'name' => 'Finance '.uniqid(),
            'slug' => 'finance-'.uniqid(),
        ]);
        $store = Store::query()->firstOrFail();

        Livewire::actingAs($this->consultant)
            ->test(EmployeeCreate::class)
            ->set('name', 'No Role User')
            ->set('email', 'no-role-user@test.com')
            ->set('department', $department->id)
            ->set('dealers', [(string) $store->id])
            ->call('submit')
            ->assertHasErrors(['role']);
    });

    it('auto assigns the single available store when inviting an employee', function (): void {
        Queue::fake();

        $department = Department::query()->create([
            'name' => 'Sales '.uniqid(),
            'slug' => 'sales-'.uniqid(),
        ]);
        $store = Store::query()->firstOrFail();

        Livewire::actingAs($this->consultant)
            ->test(EmployeeCreate::class)
            ->set('name', 'Invited Employee')
            ->set('email', 'invited-employee@test.com')
            ->set('department', $department->id)
            ->set('role', 'Employee')
            ->set('qi', true)
            ->call('submit')
            ->assertRedirect(route('dealer.employees.index'));

        $invite = Invite::query()
            ->where('email', 'invited-employee@test.com')
            ->firstOrFail();

        expect($invite->roles)->toBe(['Employee', 'Qualified Individual']);
        expect($invite->stores)->toBe([$store->id]);

        Queue::assertPushed(SendQueueEmailJob::class);
    });

    it('requires store selection when multiple stores are available', function (): void {
        Queue::fake();

        $department = Department::query()->create([
            'name' => 'Multi Store Department '.uniqid(),
            'slug' => 'multi-store-department-'.uniqid(),
        ]);

        Store::query()->create([
            'name' => 'Second Store '.uniqid(),
            'address' => '2 Main St',
            'city' => 'Nashville',
            'state' => 'TN',
            'postal_code' => '37202',
            'phone' => '615-555-0102',
            'website' => 'https://second-store.test',
        ]);

        Livewire::actingAs($this->consultant)
            ->test(EmployeeCreate::class)
            ->set('name', 'Multi Store Invite')
            ->set('email', 'multi-store-invite@test.com')
            ->set('department', $department->id)
            ->set('role', 'Employee')
            ->set('dealers', [])
            ->call('submit')
            ->assertHasErrors(['dealers']);

        expect(Invite::query()->where('email', 'multi-store-invite@test.com')->exists())->toBeFalse();
    });

    it('prefills selected store when mounted from single-store create page', function (): void {
        $store = Store::query()->firstOrFail();

        Livewire::actingAs($this->consultant)
            ->test(EmployeeCreate::class, ['store' => $store])
            ->assertSet('dealers', [(string) $store->id]);
    });
});
