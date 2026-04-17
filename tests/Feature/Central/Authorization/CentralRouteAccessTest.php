<?php

declare(strict_types=1);

use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

describe('Central Routes - Super Admin Access', function (): void {
    it('can access the central dashboard', function (): void {
        asSuperAdmin()
            ->get(route('dashboard'))
            ->assertOk();
    });

    it('can access dealerships index', function (): void {
        asSuperAdmin()
            ->get(route('dealerships.index'))
            ->assertOk();
    });

    it('can access dealership creation', function (): void {
        asSuperAdmin()
            ->get(route('dealerships.create'))
            ->assertOk();
    });

    it('can access contracts index', function (): void {
        asSuperAdmin()
            ->get(route('contracts.index'))
            ->assertOk();
    });

    it('can access contracts create', function (): void {
        asSuperAdmin()
            ->get(route('contracts.create'))
            ->assertOk();
    });

    it('can access courses index', function (): void {
        asSuperAdmin()
            ->get(route('courses.index'))
            ->assertOk();
    });

    it('can access employees index (super-admin only)', function (): void {
        asSuperAdmin()
            ->get(route('employees.index'))
            ->assertOk();
    });

    it('can access employee invite page (super-admin only)', function (): void {
        asSuperAdmin()
            ->get(route('employees.invite'))
            ->assertOk();
    });

    it('can access course management (super-admin only)', function (): void {
        asSuperAdmin()
            ->get(route('course-management.index'))
            ->assertOk();
    });

    it('can access central logs (super-admin only)', function (): void {
        asSuperAdmin()
            ->get(route('logs.index'))
            ->assertOk();
    });

    it('can access SDS index', function (): void {
        asSuperAdmin()
            ->get(route('sds.index'))
            ->assertOk();
    });

    it('can access SDS create', function (): void {
        asSuperAdmin()
            ->get(route('sds.create'))
            ->assertOk();
    });

    it('can access documents index', function (): void {
        asSuperAdmin()
            ->get(route('docs.index'))
            ->assertOk();
    });

    it('can access documents create', function (): void {
        asSuperAdmin()
            ->get(route('docs.create'))
            ->assertOk();
    });

    it('can access osha violations index', function (): void {
        asSuperAdmin()
            ->get(route('osha-violations.index'))
            ->assertOk();
    });

    it('can access osha violations create (super-admin only)', function (): void {
        asSuperAdmin()
            ->get(route('osha-violations.create'))
            ->assertOk();
    });

    it('can access body shop violations index', function (): void {
        asSuperAdmin()
            ->get(route('body-shop-violations.index'))
            ->assertOk();
    });

    it('can access body shop violations create (super-admin only)', function (): void {
        asSuperAdmin()
            ->get(route('body-shop-violations.create'))
            ->assertOk();
    });

    it('can access glba violations index', function (): void {
        asSuperAdmin()
            ->get(route('glba-violations.index'))
            ->assertOk();
    });

    it('can access glba violations create (super-admin only)', function (): void {
        asSuperAdmin()
            ->get(route('glba-violations.create'))
            ->assertOk();
    });

    it('can access dealer docs index (super-admin only)', function (): void {
        asSuperAdmin()
            ->get(route('dealer-docs.index'))
            ->assertOk();
    });

    it('can access dealer docs create (super-admin only)', function (): void {
        asSuperAdmin()
            ->get(route('dealer-docs.create'))
            ->assertOk();
    });

    it('can access videos index', function (): void {
        asSuperAdmin()
            ->get(route('videos.index'))
            ->assertOk();
    });

    it('can access profile', function (): void {
        asSuperAdmin()
            ->get(route('profile.edit'))
            ->assertOk();
    });

    it('can access dealer login lookup', function (): void {
        asSuperAdmin()
            ->get(route('dealer-login'))
            ->assertOk();
    });
});

describe('Central Routes - Consultant Access', function (): void {
    it('can access the central dashboard', function (): void {
        asConsultant()
            ->get(route('dashboard'))
            ->assertOk();
    });

    it('can access dealerships index', function (): void {
        asConsultant()
            ->get(route('dealerships.index'))
            ->assertOk();
    });

    it('can access contracts index', function (): void {
        asConsultant()
            ->get(route('contracts.index'))
            ->assertOk();
    });

    it('can access courses index', function (): void {
        asConsultant()
            ->get(route('courses.index'))
            ->assertOk();
    });

    it('can access SDS index', function (): void {
        asConsultant()
            ->get(route('sds.index'))
            ->assertOk();
    });

    it('can access documents index', function (): void {
        asConsultant()
            ->get(route('docs.index'))
            ->assertOk();
    });

    it('can access osha violations index', function (): void {
        asConsultant()
            ->get(route('osha-violations.index'))
            ->assertOk();
    });

    it('can access body shop violations index', function (): void {
        asConsultant()
            ->get(route('body-shop-violations.index'))
            ->assertOk();
    });

    it('can access glba violations index', function (): void {
        asConsultant()
            ->get(route('glba-violations.index'))
            ->assertOk();
    });

    it('can access profile', function (): void {
        asConsultant()
            ->get(route('profile.edit'))
            ->assertOk();
    });
});

describe('Central Routes - Consultant Cannot Access Super-Admin Only Routes', function (): void {
    it('cannot access employees index', function (): void {
        asConsultant()
            ->get(route('employees.index'))
            ->assertForbidden();
    });

    it('cannot access employee invite page', function (): void {
        asConsultant()
            ->get(route('employees.invite'))
            ->assertForbidden();
    });

    it('cannot access course management', function (): void {
        asConsultant()
            ->get(route('course-management.index'))
            ->assertForbidden();
    });

    it('cannot access central logs', function (): void {
        asConsultant()
            ->get(route('logs.index'))
            ->assertForbidden();
    });

    it('cannot access osha violations create', function (): void {
        asConsultant()
            ->get(route('osha-violations.create'))
            ->assertForbidden();
    });

    it('cannot access body shop violations create', function (): void {
        asConsultant()
            ->get(route('body-shop-violations.create'))
            ->assertForbidden();
    });

    it('cannot access glba violations create', function (): void {
        asConsultant()
            ->get(route('glba-violations.create'))
            ->assertForbidden();
    });

    it('cannot access dealer docs index', function (): void {
        asConsultant()
            ->get(route('dealer-docs.index'))
            ->assertForbidden();
    });
});

describe('Central Routes - Unauthorized Roles', function (): void {
    it('denies access to non super-admin|Consultant roles', function (): void {
        $user = User::factory()->create();
        $user->assignRole('Manager');
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        test()->actingAs($user)
            ->get(route('dashboard'))
            ->assertForbidden();
    });

    it('denies employee access to central dashboard', function (): void {
        $user = User::factory()->create();
        $user->assignRole('Employee');
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        test()->actingAs($user)
            ->get(route('dashboard'))
            ->assertForbidden();
    });
});

describe('Central Routes - Guest Access', function (): void {
    it('redirects unauthenticated users to login', function (): void {
        test()->get(route('dashboard'))
            ->assertRedirect(route('login'));
    });

    it('redirects unauthenticated users from dealerships', function (): void {
        test()->get(route('dealerships.index'))
            ->assertRedirect(route('login'));
    });

    it('redirects unauthenticated users from contracts', function (): void {
        test()->get(route('contracts.index'))
            ->assertRedirect(route('login'));
    });

    it('redirects unauthenticated users from courses', function (): void {
        test()->get(route('courses.index'))
            ->assertRedirect(route('login'));
    });
});
