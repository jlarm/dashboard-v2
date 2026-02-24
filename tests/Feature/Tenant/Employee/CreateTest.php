<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Employee\Create as EmployeeCreate;
use App\Http\Livewire\Dealer\Store\SingleStore\Employee\Create as SingleStoreEmployeeCreate;
use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Department;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\Queue;
use Livewire\Livewire;

describe('employee create component', function (): void {
    it('requires exactly one role selection via role dropdown', function (): void {
        $this->tenant->locations = true;
        $this->tenant->save();

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

    it('creates invite with one selected role and optional qualified individual role', function (): void {
        Queue::fake();

        $this->tenant->locations = true;
        $this->tenant->save();

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
            ->set('dealers', [(string) $store->id])
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

    it('prefills selected store when mounted from single-store create page', function (): void {
        $store = Store::query()->firstOrFail();

        Livewire::actingAs($this->consultant)
            ->test(SingleStoreEmployeeCreate::class, ['store' => $store])
            ->assertStatus(200)
            ->assertSet('store.id', $store->id);

        Livewire::actingAs($this->consultant)
            ->test(EmployeeCreate::class, ['store' => $store])
            ->assertSet('dealers', [(string) $store->id]);
    });
});
