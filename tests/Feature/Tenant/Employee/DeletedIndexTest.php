<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Employee\DeletedIndex;
use App\Models\Dealer\Department;
use App\Models\User;
use Livewire\Livewire;

it('renders deleted dealer employees in the table component with title-cased names', function (): void {
    $department = Department::query()->create([
        'name' => 'Service '.uniqid(),
        'slug' => 'service-'.uniqid(),
    ]);

    $deletedEmployee = User::query()->create([
        'name' => 'Deleted Dealer Employee',
        'email' => 'deleted-dealer-employee@test.com',
        'password' => bcrypt('password'),
        'department_id' => $department->id,
    ]);
    $deletedEmployee->assignRole('Employee');
    $deletedEmployee->delete();

    $this->actingAs($this->consultant)
        ->get(route('dealer.employees.deleted'))
        ->assertOk()
        ->assertSee('min-w-full divide-y divide-gray-300', false)
        ->assertSee('pl-4 pr-3', false)
        ->assertSee('Deleted Dealer Employee')
        ->assertSee('Service')
        ->assertSee('Restore');
});

it('searches deleted employees by name and email', function (): void {
    $department = Department::query()->create([
        'name' => 'Sales '.uniqid(),
        'slug' => 'sales-'.uniqid(),
    ]);

    $alphaEmployee = User::query()->create([
        'name' => 'Alpha Deleted',
        'email' => 'alpha-deleted@test.com',
        'password' => bcrypt('password'),
        'department_id' => $department->id,
    ]);
    $alphaEmployee->assignRole('Employee');
    $alphaEmployee->delete();

    $betaEmployee = User::query()->create([
        'name' => 'Beta Deleted',
        'email' => 'beta-deleted@test.com',
        'password' => bcrypt('password'),
        'department_id' => $department->id,
    ]);
    $betaEmployee->assignRole('Employee');
    $betaEmployee->delete();

    Livewire::actingAs($this->consultant)
        ->test(DeletedIndex::class)
        ->set('search', 'alpha')
        ->assertSee('Alpha Deleted')
        ->assertDontSee('Beta Deleted')
        ->set('search', 'beta-deleted@test.com')
        ->assertSee('Beta Deleted')
        ->assertDontSee('Alpha Deleted');
});

it('paginates deleted employees', function (): void {
    $department = Department::query()->create([
        'name' => 'Paged '.uniqid(),
        'slug' => 'paged-'.uniqid(),
    ]);

    for ($index = 1; $index <= 26; $index++) {
        $label = mb_str_pad((string) $index, 2, '0', STR_PAD_LEFT);

        $user = User::query()->create([
            'name' => "Page User {$label}",
            'email' => "page-user-{$index}@test.com",
            'password' => bcrypt('password'),
            'department_id' => $department->id,
        ]);
        $user->assignRole('Employee');
        $user->delete();
    }

    Livewire::actingAs($this->consultant)
        ->test(DeletedIndex::class)
        ->assertSee('Page User 26')
        ->assertDontSee('Page User 01')
        ->call('gotoPage', 2)
        ->assertSee('Page User 01')
        ->assertDontSee('Page User 26');
});
