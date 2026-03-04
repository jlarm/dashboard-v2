<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Employee\Create as EmployeeCreate;
use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Department;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\Queue;
use Livewire\Livewire;

describe('employee create component', function (): void {
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
