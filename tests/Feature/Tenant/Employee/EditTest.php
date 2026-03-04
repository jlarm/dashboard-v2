<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Employee\Delete as EmployeeDelete;
use App\Http\Livewire\Dealer\Employee\Edit as EmployeeEdit;
use App\Models\Dealer\Store;
use App\Models\User;
use Livewire\Livewire;

describe('employee edit component', function (): void {
    it('shows store assignment options when tenant has more than one store', function (): void {
        $primaryStore = Store::query()->firstOrFail();
        $secondaryStore = Store::query()->create([
            'name' => 'Employee Edit Store '.uniqid(),
            'address' => '5 Main St',
            'city' => 'Nashville',
            'state' => 'TN',
            'postal_code' => '37211',
            'phone' => '615-555-0105',
            'website' => 'https://employee-edit-store.test',
        ]);

        $employee = User::query()->create([
            'name' => 'Edit Employee',
            'email' => 'edit-employee-'.uniqid().'@test.com',
            'password' => bcrypt('password'),
        ]);
        $employee->assignRole('Employee');
        $employee->stores()->sync([$primaryStore->id, $secondaryStore->id]);

        app()->instance('currentStore', $primaryStore->id);

        Livewire::actingAs($this->consultant)
            ->test(EmployeeEdit::class, ['user' => $employee])
            ->assertSet('showStoreAssignment', true)
            ->assertSee('Select Store(s)');
    });

    it('hides store assignment options when tenant has one store', function (): void {
        $store = Store::query()->firstOrFail();

        $employee = User::query()->create([
            'name' => 'Single Store Employee',
            'email' => 'single-store-employee-'.uniqid().'@test.com',
            'password' => bcrypt('password'),
        ]);
        $employee->assignRole('Employee');
        $employee->stores()->sync([$store->id]);

        app()->instance('currentStore', $store->id);

        Livewire::actingAs($this->consultant)
            ->test(EmployeeEdit::class, ['user' => $employee])
            ->assertSet('showStoreAssignment', false)
            ->assertDontSee('Select Store(s)');
    });

    it('mounts edit and delete employee components when no store is selected', function (): void {
        $primaryStore = Store::query()->firstOrFail();
        $secondaryStore = Store::query()->create([
            'name' => 'Overview Employee Store '.uniqid(),
            'address' => '9 Main St',
            'city' => 'Nashville',
            'state' => 'TN',
            'postal_code' => '37211',
            'phone' => '615-555-0109',
            'website' => 'https://overview-employee-store.test',
        ]);

        $employee = User::query()->create([
            'name' => 'Overview Employee',
            'email' => 'overview-employee-'.uniqid().'@test.com',
            'password' => bcrypt('password'),
        ]);
        $employee->assignRole('Employee');
        $employee->stores()->sync([$primaryStore->id, $secondaryStore->id]);

        app()->instance('currentStore', null);

        Livewire::actingAs($this->consultant)
            ->test(EmployeeEdit::class, ['user' => $employee])
            ->assertSet('showStoreAssignment', true)
            ->assertSet('remediationRemindersActive', false)
            ->assertSee('Select Store(s)');

        Livewire::actingAs($this->consultant)
            ->test(EmployeeDelete::class, ['user' => $employee])
            ->assertOk()
            ->assertSee('Delete Employee');
    });
});
