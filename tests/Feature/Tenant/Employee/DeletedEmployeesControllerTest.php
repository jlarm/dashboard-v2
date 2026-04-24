<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\Department;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->department = Department::query()->create([
        'name' => 'Deleted Dept '.uniqid(),
        'slug' => 'deleted-dept-'.uniqid(),
    ]);

    $this->trashed = User::query()->create([
        'name' => 'Trashed Employee',
        'email' => 'trashed@test.com',
        'password' => bcrypt('password'),
        'department_id' => $this->department->id,
    ]);
    $this->trashed->assignRole('Employee');
    $this->trashed->stores()->attach(Store::query()->value('id'));
    $this->trashed->delete();

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

describe('employees deleted endpoint', function (): void {
    it('renders the deleted page with trashed users', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.deleted'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/user/Deleted')
                ->has('employees.data', 1)
                ->where('employees.data.0.email', 'trashed@test.com'),
            );
    });

    it('filters by search string', function (): void {
        $other = User::query()->create([
            'name' => 'Other Trashed',
            'email' => 'other-trashed@test.com',
            'password' => bcrypt('password'),
            'department_id' => $this->department->id,
        ]);
        $other->delete();

        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.deleted', ['search' => 'Trashed Employee']))
            ->assertInertia(fn ($page) => $page
                ->has('employees.data', 1)
                ->where('employees.data.0.name', 'Trashed Employee'),
            );
    });

    it('restores a trashed employee', function (): void {
        $this->actingAs($this->consultant)
            ->post(route('dealer.employees.deleted.restore', $this->trashed->id))
            ->assertRedirect()
            ->assertSessionHas('success');

        expect(User::query()->find($this->trashed->id))->not->toBeNull();
        expect($this->trashed->fresh()->trashed())->toBeFalse();
    });

    it('404s when restoring a user that is not soft-deleted', function (): void {
        $active = User::query()->create([
            'name' => 'Active User',
            'email' => 'active-user@test.com',
            'password' => bcrypt('password'),
            'department_id' => $this->department->id,
        ]);

        $this->actingAs($this->consultant)
            ->post(route('dealer.employees.deleted.restore', $active->id))
            ->assertNotFound();
    });

    it('forbids users without the required roles', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.employees.deleted'))
            ->assertForbidden();

        $this->actingAs($this->manager)
            ->post(route('dealer.employees.deleted.restore', $this->trashed->id))
            ->assertForbidden();
    });
});
