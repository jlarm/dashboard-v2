<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\Department;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();

    $this->consultant->stores()->attach($this->store->id);
    $this->consultant->update(['current_store_id' => $this->store->id]);
    $this->manager->stores()->attach($this->store->id);
    $this->manager->update(['current_store_id' => $this->store->id]);

    $this->department = Department::query()->create([
        'name' => 'Default Dept '.uniqid(),
        'slug' => 'default-dept-'.uniqid(),
    ]);

    $this->target = User::query()->create([
        'name' => 'Target Employee',
        'email' => 'target@test.com',
        'password' => bcrypt('password'),
        'department_id' => $this->department->id,
    ]);
    $this->target->assignRole('Employee');
    $this->target->stores()->attach($this->store->id);

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

/**
 * Create a tenant user with the given role in the test store.
 */
function makeShowTenantUser(string $role, array $overrides = []): User
{
    static $counter = 0;
    $counter++;

    $user = User::query()->create(array_merge([
        'name' => "Show {$role} {$counter}",
        'email' => "show-{$counter}-".str($role)->slug().'@test.com',
        'password' => bcrypt('password'),
    ], $overrides));

    $user->assignRole($role);
    $user->stores()->attach(test()->store->id);

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    return $user;
}

describe('show page role access', function (): void {
    it('redirects guests to login', function (): void {
        $this->get(route('dealer.employees.show', $this->target))
            ->assertRedirect(route('dealer.login'));
    });

    it('allows privileged roles to view an in-scope employee', function (string $role): void {
        $viewer = makeShowTenantUser($role);

        $this->actingAs($viewer)
            ->get(route('dealer.employees.show', $this->target))
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

    it('forbids unprivileged roles from viewing any employee', function (string $role): void {
        $viewer = makeShowTenantUser($role);

        $this->actingAs($viewer)
            ->get(route('dealer.employees.show', $this->target))
            ->assertForbidden();
    })->with([
        'Employee',
        'Porter/Driver',
    ]);

    it('forbids viewing yourself', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.show', $this->consultant))
            ->assertForbidden();
    });

    it('forbids viewing a super-admin target', function (): void {
        $superAdminTarget = makeShowTenantUser('super-admin', ['email' => 'sa-target@test.com']);

        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.show', $superAdminTarget))
            ->assertForbidden();
    });

    it('forbids viewing a Consultant target', function (): void {
        $consultantTarget = makeShowTenantUser('Consultant', ['email' => 'consultant-target@test.com']);

        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.show', $consultantTarget))
            ->assertForbidden();
    });

    it('forbids Managers from viewing employees in other departments', function (): void {
        $salesDept = Department::query()->create([
            'name' => 'Sales '.uniqid(),
            'slug' => 'sales-'.uniqid(),
        ]);
        $serviceDept = Department::query()->create([
            'name' => 'Service '.uniqid(),
            'slug' => 'service-'.uniqid(),
        ]);

        $this->manager->update(['department_id' => $salesDept->id]);
        $this->target->update(['department_id' => $serviceDept->id]);

        $this->actingAs($this->manager)
            ->get(route('dealer.employees.show', $this->target))
            ->assertForbidden();
    });
});

describe('show page payload', function (): void {
    it('renders the tenant Inertia show component with expected props', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.show', $this->target))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/user/Show')
                ->where('employee.id', $this->target->id)
                ->has('permissions.update')
                ->has('permissions.delete')
                ->has('permissions.impersonate')
                ->has('permissions.manage_courses'),
            );
    });

    it('returns editOptions when the viewer may update the target', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.show', $this->target))
            ->assertInertia(fn ($page) => $page
                ->has('editOptions.departments')
                ->has('editOptions.roles')
                ->has('editOptions.audit_types', 3)
                ->has('editOptions.stores'),
            );
    });

    it('omits the stores option when the tenant only has a single store', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.show', $this->target))
            ->assertInertia(fn ($page) => $page->where('editOptions.stores', null));
    });

    it('includes remediationReminders for the target', function (): void {
        $this->target->remediationReminderPreferences()->create([
            'audit_type' => 'OSHA',
            'enabled' => true,
        ]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.show', $this->target))
            ->assertInertia(fn ($page) => $page->where('remediationReminders', ['OSHA']));
    });

    it('omits editOptions when the viewer cannot update the target', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.employees.show', $this->target))
            ->assertInertia(fn ($page) => $page->where('editOptions', null));
    });

    it('filters privileged role names out of editOptions', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.show', $this->target))
            ->assertInertia(fn ($page) => $page->where(
                'editOptions.roles',
                fn ($roles) => collect($roles)
                    ->pluck('name')
                    ->intersect(['super-admin', 'Consultant', 'Qualified Individual'])
                    ->isEmpty(),
            ));
    });
});

describe('sub-page role access', function (): void {
    it('renders the Courses sub-page for any privileged role', function (string $role): void {
        $viewer = makeShowTenantUser($role);

        $this->actingAs($viewer)
            ->get(route('dealer.employees.show.courses', $this->target))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/user/Courses')
                ->has('courses')
                ->has('canRecordCourseResult'),
            );
    })->with(['super-admin', 'Consultant', 'Manager']);

    it('renders the DOT Certificates sub-page for any privileged role', function (string $role): void {
        $viewer = makeShowTenantUser($role);

        $this->actingAs($viewer)
            ->get(route('dealer.employees.show.dot-certificates', $this->target))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('tenant/user/DotCertificates'));
    })->with(['super-admin', 'Consultant', 'Manager']);

    it('allows privileged roles to access the Manage Courses sub-page', function (string $role): void {
        $viewer = makeShowTenantUser($role);

        $this->actingAs($viewer)
            ->get(route('dealer.employees.show.manage-courses', $this->target))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('tenant/user/ManageCourses'));
    })->with(['super-admin', 'Consultant', 'Qualified Individual']);

    it('forbids non-privileged roles from the Manage Courses sub-page', function (string $role): void {
        $viewer = makeShowTenantUser($role);

        $this->actingAs($viewer)
            ->get(route('dealer.employees.show.manage-courses', $this->target))
            ->assertForbidden();
    })->with(['Owner', 'CFO', 'GM', 'GSM', 'Manager']);
});

describe('update action', function (): void {
    it('allows an authorized viewer to update department and role', function (): void {
        $department = Department::query()->create([
            'name' => 'Accounting '.uniqid(),
            'slug' => 'accounting-'.uniqid(),
        ]);
        $managerRoleId = Role::query()->where('name', 'Manager')->value('id');

        $this->actingAs($this->consultant)
            ->patch(route('dealer.employees.update', $this->target), [
                'department_id' => $department->id,
                'role_id' => $managerRoleId,
                'qualified_individual' => false,
            ])
            ->assertRedirect();

        $this->target->refresh();

        expect($this->target->department_id)->toBe($department->id)
            ->and($this->target->hasRole('Manager'))->toBeTrue()
            ->and($this->target->hasRole('Qualified Individual'))->toBeFalse();
    });

    it('adds the Qualified Individual role when qualified_individual is true', function (): void {
        $ownerRoleId = Role::query()->where('name', 'Owner')->value('id');

        $this->actingAs($this->consultant)
            ->patch(route('dealer.employees.update', $this->target), [
                'department_id' => $this->department->id,
                'role_id' => $ownerRoleId,
                'qualified_individual' => true,
            ])
            ->assertRedirect();

        $this->target->refresh();

        expect($this->target->hasRole('Owner'))->toBeTrue()
            ->and($this->target->hasRole('Qualified Individual'))->toBeTrue();
    });

    it('replaces remediation reminder preferences with the submitted audit types', function (): void {
        $this->target->remediationReminderPreferences()->create([
            'audit_type' => 'GLBA',
            'enabled' => true,
        ]);

        $employeeRoleId = Role::query()->where('name', 'Employee')->value('id');

        $this->actingAs($this->consultant)
            ->patch(route('dealer.employees.update', $this->target), [
                'department_id' => $this->department->id,
                'role_id' => $employeeRoleId,
                'qualified_individual' => false,
                'audit_types' => ['OSHA', 'BODYSHOP'],
            ])
            ->assertRedirect();

        $this->target->refresh();
        $types = $this->target->remediationReminderPreferences()
            ->pluck('audit_type')
            ->map(static fn ($type) => is_string($type) ? $type : $type->value)
            ->sort()
            ->values()
            ->all();

        expect($types)->toBe(['BODYSHOP', 'OSHA']);
    });

    it('rejects unknown audit type values', function (): void {
        $employeeRoleId = Role::query()->where('name', 'Employee')->value('id');

        $this->actingAs($this->consultant)
            ->patch(route('dealer.employees.update', $this->target), [
                'department_id' => $this->department->id,
                'role_id' => $employeeRoleId,
                'qualified_individual' => false,
                'audit_types' => ['BOGUS'],
            ])
            ->assertSessionHasErrors('audit_types.0');
    });

    it('forbids Manager actors from updating', function (): void {
        $employeeRoleId = Role::query()->where('name', 'Employee')->value('id');

        $this->actingAs($this->manager)
            ->patch(route('dealer.employees.update', $this->target), [
                'department_id' => $this->department->id,
                'role_id' => $employeeRoleId,
                'qualified_individual' => false,
            ])
            ->assertForbidden();
    });

    it('requires a role_id', function (): void {
        $this->actingAs($this->consultant)
            ->patch(route('dealer.employees.update', $this->target), [
                'department_id' => $this->department->id,
                'qualified_individual' => false,
            ])
            ->assertSessionHasErrors('role_id');
    });

    it('requires a department_id', function (): void {
        $employeeRoleId = Role::query()->where('name', 'Employee')->value('id');

        $this->actingAs($this->consultant)
            ->patch(route('dealer.employees.update', $this->target), [
                'role_id' => $employeeRoleId,
                'qualified_individual' => false,
            ])
            ->assertSessionHasErrors('department_id');
    });

    it('rejects role ids that do not exist', function (): void {
        $this->actingAs($this->consultant)
            ->patch(route('dealer.employees.update', $this->target), [
                'department_id' => $this->department->id,
                'role_id' => 9999999,
                'qualified_individual' => false,
            ])
            ->assertSessionHasErrors('role_id');
    });

    it('rejects attempts to assign a Consultant role', function (): void {
        $consultantRoleId = Role::query()->where('name', 'Consultant')->value('id');

        $this->actingAs($this->consultant)
            ->patch(route('dealer.employees.update', $this->target), [
                'department_id' => $this->department->id,
                'role_id' => $consultantRoleId,
                'qualified_individual' => false,
            ])
            ->assertServerError();
    });
});

describe('record course result action', function (): void {
    it('creates a passing course result with the submitted date', function (): void {
        $course = App\Models\Dealer\Course::query()->create([
            'name' => 'Record Test Course',
            'slug' => 'record-test-course-'.uniqid(),
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $takenOn = now()->subMonth()->startOfDay();

        $this->actingAs($this->consultant)
            ->post(
                route('dealer.employees.courses.record-result', [
                    'user' => $this->target,
                    'course' => $course->id,
                ]),
                ['taken_on' => $takenOn->toDateString()],
            )
            ->assertRedirect();

        $result = App\Models\Dealer\CourseResults::query()
            ->where('user_id', $this->target->id)
            ->where('course_id', $course->id)
            ->firstOrFail();

        expect((int) $result->passed)->toBe(1)
            ->and((int) $result->percentage)->toBe(100)
            ->and($result->created_at->toDateString())->toBe($takenOn->toDateString());
    });

    it('rejects future dates', function (): void {
        $course = App\Models\Dealer\Course::query()->create([
            'name' => 'Future Date Course',
            'slug' => 'future-date-course-'.uniqid(),
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $this->actingAs($this->consultant)
            ->post(
                route('dealer.employees.courses.record-result', [
                    'user' => $this->target,
                    'course' => $course->id,
                ]),
                ['taken_on' => now()->addDay()->toDateString()],
            )
            ->assertSessionHasErrors('taken_on');
    });

    it('forbids actors without the create-dealerships permission', function (): void {
        $course = App\Models\Dealer\Course::query()->create([
            'name' => 'Unauthorized Course',
            'slug' => 'unauthorized-course-'.uniqid(),
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $this->actingAs($this->manager)
            ->post(
                route('dealer.employees.courses.record-result', [
                    'user' => $this->target,
                    'course' => $course->id,
                ]),
                ['taken_on' => now()->toDateString()],
            )
            ->assertForbidden();
    });
});

describe('destroy action', function (): void {
    it('soft-deletes the target when authorized', function (): void {
        $this->actingAs($this->consultant)
            ->delete(route('dealer.employees.destroy', $this->target))
            ->assertRedirect(route('dealer.employees.index'));

        expect(User::withTrashed()->find($this->target->id)->trashed())->toBeTrue();
    });

    it('forbids Manager actors from deleting employees', function (): void {
        $this->actingAs($this->manager)
            ->delete(route('dealer.employees.destroy', $this->target))
            ->assertForbidden();

        expect(User::query()->find($this->target->id))->not->toBeNull();
    });

    it('forbids deleting yourself', function (): void {
        $this->actingAs($this->consultant)
            ->delete(route('dealer.employees.destroy', $this->consultant))
            ->assertForbidden();
    });

    it('forbids deleting a super-admin target', function (): void {
        $superAdminTarget = makeShowTenantUser('super-admin', ['email' => 'sa-delete-target@test.com']);

        $this->actingAs($this->consultant)
            ->delete(route('dealer.employees.destroy', $superAdminTarget))
            ->assertForbidden();
    });
});

describe('impersonate action', function (): void {
    it('allows a Consultant to start impersonation', function (): void {
        $this->actingAs($this->consultant)
            ->post(route('dealer.employees.impersonate', $this->target))
            ->assertRedirect();
    });

    it('allows a super-admin to start impersonation', function (): void {
        $superAdmin = makeShowTenantUser('super-admin', ['email' => 'sa-imper-actor@test.com']);

        $this->actingAs($superAdmin)
            ->post(route('dealer.employees.impersonate', $this->target))
            ->assertRedirect();
    });

    it('forbids a Manager from impersonating', function (): void {
        $this->actingAs($this->manager)
            ->post(route('dealer.employees.impersonate', $this->target))
            ->assertForbidden();
    });

    it('forbids impersonating yourself', function (): void {
        $this->actingAs($this->consultant)
            ->post(route('dealer.employees.impersonate', $this->consultant))
            ->assertForbidden();
    });

    it('forbids impersonating a super-admin target', function (): void {
        $superAdminTarget = makeShowTenantUser('super-admin', ['email' => 'sa-imper-target@test.com']);

        $this->actingAs($this->consultant)
            ->post(route('dealer.employees.impersonate', $superAdminTarget))
            ->assertForbidden();
    });
});
