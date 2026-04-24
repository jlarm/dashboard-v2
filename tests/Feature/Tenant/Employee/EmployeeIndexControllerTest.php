<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\Department;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();

    $this->consultant->stores()->attach($this->store->id);
    $this->consultant->update(['current_store_id' => $this->store->id]);
    $this->manager->stores()->attach($this->store->id);
    $this->manager->update(['current_store_id' => $this->store->id]);

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

/**
 * Create a tenant user with the given role in the test store.
 */
function makeTenantUser(string $role, array $overrides = []): User
{
    static $counter = 0;
    $counter++;

    $user = User::query()->create(array_merge([
        'name' => "Test {$role} {$counter}",
        'email' => "test-{$counter}-".str($role)->slug().'@test.com',
        'password' => bcrypt('password'),
    ], $overrides));

    $user->assignRole($role);
    $user->stores()->attach(test()->store->id);

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    return $user;
}

describe('index page role access', function (): void {
    it('redirects guests to login', function (): void {
        $this->get(route('dealer.employees.index'))
            ->assertRedirect(route('dealer.login'));
    });

    it('allows privileged roles', function (string $role): void {
        $user = makeTenantUser($role);

        $this->actingAs($user)
            ->get(route('dealer.employees.index'))
            ->assertOk();
    })->with([
        'super-admin',
        'Consultant',
        'Owner',
        'CFO',
        'GM',
        'GSM',
        'Qualified Individual',
        'Manager',
    ]);

    it('forbids unprivileged roles', function (string $role): void {
        $user = makeTenantUser($role);

        $this->actingAs($user)
            ->get(route('dealer.employees.index'))
            ->assertForbidden();
    })->with([
        'Employee',
        'Porter/Driver',
    ]);
});

describe('index page payload', function (): void {
    it('renders the tenant Inertia index component with the expected props', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/user/Index')
                ->has('employees.data')
                ->has('trainingCounts')
                ->has('filters')
                ->has('filterOptions.departments')
                ->has('filterOptions.roles')
                ->has('permissions.manage_filters')
                ->has('permissions.email_report')
                ->has('permissions.send_message')
                ->has('storeContext.multiple_stores')
                ->has('storeContext.current_store_name'),
            );
    });

    it('excludes super-admin and Consultant users from the listing', function (): void {
        $superAdmin = makeTenantUser('super-admin', ['email' => 'excluded-super@test.com']);
        $hiddenConsultant = makeTenantUser('Consultant', ['email' => 'excluded-consultant@test.com']);
        $employee = makeTenantUser('Employee', ['email' => 'visible-employee@test.com']);

        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->where(
                'employees.data',
                fn ($rows) => collect($rows)
                    ->pluck('id')
                    ->contains($employee->id)
                    && ! collect($rows)->pluck('id')->contains($superAdmin->id)
                    && ! collect($rows)->pluck('id')->contains($hiddenConsultant->id),
            ));
    });

    it('grants manage_filters permission to users with the create-stores ability', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.index'))
            ->assertInertia(fn ($page) => $page->where('permissions.manage_filters', true));
    });

    it('denies manage_filters permission to users without the create-stores ability', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.employees.index'))
            ->assertInertia(fn ($page) => $page->where('permissions.manage_filters', false));
    });

    it('denies send_message permission to Manager, Employee, and Porter/Driver actors', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.employees.index'))
            ->assertInertia(fn ($page) => $page->where('permissions.send_message', false));
    });

    it('allows send_message permission for Consultant actors', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.index'))
            ->assertInertia(fn ($page) => $page->where('permissions.send_message', true));
    });
});

describe('index page scoping', function (): void {
    it('limits Manager actors to users in their own department', function (): void {
        $salesDepartment = Department::query()->create([
            'name' => 'Sales '.uniqid(),
            'slug' => 'sales-'.uniqid(),
        ]);
        $serviceDepartment = Department::query()->create([
            'name' => 'Service '.uniqid(),
            'slug' => 'service-'.uniqid(),
        ]);

        $this->manager->update(['department_id' => $salesDepartment->id]);

        $visible = makeTenantUser('Employee', [
            'email' => 'sales-employee@test.com',
            'department_id' => $salesDepartment->id,
        ]);
        $hidden = makeTenantUser('Employee', [
            'email' => 'service-employee@test.com',
            'department_id' => $serviceDepartment->id,
        ]);

        $this->actingAs($this->manager)
            ->get(route('dealer.employees.index'))
            ->assertInertia(fn ($page) => $page->where(
                'employees.data',
                fn ($rows) => collect($rows)->pluck('id')->contains($visible->id)
                    && ! collect($rows)->pluck('id')->contains($hidden->id),
            ));
    });
});

describe('index page filtering', function (): void {
    it('filters employees by search term against name and email', function (): void {
        $targetName = makeTenantUser('Employee', [
            'name' => 'Findable Name Alpha',
            'email' => 'findable-alpha@test.com',
        ]);
        $targetEmail = makeTenantUser('Employee', [
            'name' => 'Nondescript Beta',
            'email' => 'findable-beta@test.com',
        ]);
        $other = makeTenantUser('Employee', [
            'name' => 'Unrelated Employee',
            'email' => 'unrelated@test.com',
        ]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.index', ['search' => 'findable']))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->where(
                'employees.data',
                fn ($rows) => $ids = collect($rows)->pluck('id')->all() and
                    in_array($targetName->id, $ids, true)
                    && in_array($targetEmail->id, $ids, true)
                    && ! in_array($other->id, $ids, true),
            ));
    });

    it('filters employees by department_ids', function (): void {
        $financeDept = Department::query()->create([
            'name' => 'Finance '.uniqid(),
            'slug' => 'finance-'.uniqid(),
        ]);
        $itDept = Department::query()->create([
            'name' => 'IT '.uniqid(),
            'slug' => 'it-'.uniqid(),
        ]);

        $financeEmployee = makeTenantUser('Employee', [
            'email' => 'finance-filter@test.com',
            'department_id' => $financeDept->id,
        ]);
        $itEmployee = makeTenantUser('Employee', [
            'email' => 'it-filter@test.com',
            'department_id' => $itDept->id,
        ]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.index', [
                'department_ids' => [$financeDept->id],
            ]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->where(
                'employees.data',
                fn ($rows) => $ids = collect($rows)->pluck('id')->all() and
                    in_array($financeEmployee->id, $ids, true)
                    && ! in_array($itEmployee->id, $ids, true),
            ));
    });

    it('filters employees by role_ids', function (): void {
        $ownerRoleId = Spatie\Permission\Models\Role::query()
            ->where('name', 'Owner')
            ->value('id');

        $owner = makeTenantUser('Owner', ['email' => 'filter-owner@test.com']);
        $regularEmployee = makeTenantUser('Employee', ['email' => 'filter-regular-employee@test.com']);

        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.index', [
                'role_ids' => [$ownerRoleId],
            ]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->where(
                'employees.data',
                fn ($rows) => $ids = collect($rows)->pluck('id')->all() and
                    in_array($owner->id, $ids, true)
                    && ! in_array($regularEmployee->id, $ids, true),
            ));
    });

    it('rejects filter values that fail exists validation', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.index', [
                'department_ids' => [999999],
            ]))
            ->assertSessionHasErrors('department_ids.0');
    });

    it('rejects unknown sort_field values', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.index', ['sort_field' => 'bogus']))
            ->assertSessionHasErrors('sort_field');
    });
});
