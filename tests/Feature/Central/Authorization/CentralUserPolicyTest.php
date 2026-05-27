<?php

declare(strict_types=1);

use App\Models\User;
use App\Policies\Central\UserPolicy;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('model_has_roles')->truncate();
    DB::table('model_has_permissions')->truncate();
    DB::table('users')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

function centralUser(string $role): User
{
    $user = User::factory()->create();
    $user->assignRole($role);

    return $user;
}

describe('Central\UserPolicy basic gates', function (): void {
    $policy = new UserPolicy;

    it('denies viewAny / view / viewDeleted / create / restore / forceDelete for every role at the policy level', function () use ($policy): void {
        foreach (['super-admin', 'Consultant', 'Manager', 'Employee'] as $role) {
            $u = centralUser($role);
            $other = centralUser('Employee');
            expect($policy->viewAny($u))->toBeFalse();
            expect($policy->view($u, $other))->toBeFalse();
            expect($policy->viewDeleted($u))->toBeFalse();
            expect($policy->create($u))->toBeFalse();
            expect($policy->restore($u, $other))->toBeFalse();
            expect($policy->forceDelete($u, $other))->toBeFalse();
        }
    });
});

describe('update + delete', function (): void {
    $policy = new UserPolicy;

    it('requires create-stores permission; users without it are denied even on a regular target', function () use ($policy): void {
        $actor = centralUser('Employee');
        $target = centralUser('Employee');

        expect($policy->update($actor, $target))->toBeFalse();
        expect($policy->delete($actor, $target))->toBeFalse();
    });

    it('allows Consultants to update/delete a regular tenant user', function () use ($policy): void {
        $actor = centralUser('Consultant');
        $target = centralUser('Manager');

        expect($policy->update($actor, $target))->toBeTrue();
        expect($policy->delete($actor, $target))->toBeTrue();
    });

    it('blocks acting on yourself even with create-stores permission', function () use ($policy): void {
        $actor = centralUser('Consultant');

        expect($policy->update($actor, $actor))->toBeFalse();
        expect($policy->delete($actor, $actor))->toBeFalse();
    });

    it('blocks acting on other super-admins or Consultants', function () use ($policy): void {
        $actor = centralUser('Consultant');
        $admin = centralUser('super-admin');
        $consultant = centralUser('Consultant');

        expect($policy->update($actor, $admin))->toBeFalse();
        expect($policy->update($actor, $consultant))->toBeFalse();
        expect($policy->delete($actor, $admin))->toBeFalse();
        expect($policy->delete($actor, $consultant))->toBeFalse();
    });
});

describe('impersonate', function (): void {
    $policy = new UserPolicy;

    it('allows super-admin and Consultant to impersonate a regular user', function () use ($policy): void {
        $admin = centralUser('super-admin');
        $consultant = centralUser('Consultant');
        $target = centralUser('Manager');

        expect($policy->impersonate($admin, $target))->toBeTrue();
        expect($policy->impersonate($consultant, $target))->toBeTrue();
    });

    it('denies Manager and Employee from impersonating anyone', function () use ($policy): void {
        $target = centralUser('Employee');
        expect($policy->impersonate(centralUser('Manager'), $target))->toBeFalse();
        expect($policy->impersonate(centralUser('Employee'), $target))->toBeFalse();
    });

    it('refuses to impersonate yourself', function () use ($policy): void {
        $actor = centralUser('super-admin');
        expect($policy->impersonate($actor, $actor))->toBeFalse();
    });

    it('refuses to impersonate any other super-admin', function () use ($policy): void {
        $actor = centralUser('Consultant');
        $superAdmin = centralUser('super-admin');
        expect($policy->impersonate($actor, $superAdmin))->toBeFalse();
    });
});

describe('manageCourses', function (): void {
    $policy = new UserPolicy;

    it('allows super-admin, Consultant, and Qualified Individual to manage another user\'s courses', function () use ($policy): void {
        $target = centralUser('Employee');
        foreach (['super-admin', 'Consultant', 'Qualified Individual'] as $role) {
            expect($policy->manageCourses(centralUser($role), $target))->toBeTrue();
        }
    });

    it('denies Manager and Employee from managing courses', function () use ($policy): void {
        $target = centralUser('Employee');
        expect($policy->manageCourses(centralUser('Manager'), $target))->toBeFalse();
        expect($policy->manageCourses(centralUser('Employee'), $target))->toBeFalse();
    });

    it('refuses to manage your own courses through this method', function () use ($policy): void {
        $actor = centralUser('Consultant');
        expect($policy->manageCourses($actor, $actor))->toBeFalse();
    });
});

describe('recordCourseResult + generateDotCertificate', function (): void {
    $policy = new UserPolicy;

    it('requires create-dealerships permission (super-admin/Consultant) and a different target user', function () use ($policy): void {
        $consultant = centralUser('Consultant');
        $other = centralUser('Manager');

        foreach (['recordCourseResult', 'generateDotCertificate'] as $method) {
            expect($policy->{$method}($consultant, $other))->toBeTrue();
            expect($policy->{$method}($consultant, $consultant))->toBeFalse();
            expect($policy->{$method}(centralUser('Manager'), $other))->toBeFalse();
        }
    });
});

describe('selfIssueDotCertificate', function (): void {
    $policy = new UserPolicy;

    it('allows any persisted user to self-issue their own DOT cert', function () use ($policy): void {
        expect($policy->selfIssueDotCertificate(centralUser('Employee')))->toBeTrue();
    });

    it('denies an unsaved transient user instance', function () use ($policy): void {
        expect($policy->selfIssueDotCertificate(new User))->toBeFalse();
    });
});
