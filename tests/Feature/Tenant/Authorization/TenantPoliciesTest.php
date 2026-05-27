<?php

declare(strict_types=1);

use App\Models\Course as CentralCourse;
use App\Models\Dealer\Vendor;
use App\Models\DealerDoc;
use App\Models\SharedDocument;
use App\Models\User;
use App\Policies\CoursePolicy;
use App\Policies\CourseResultsPolicy;
use App\Policies\DealerDocPolicy;
use App\Policies\GlobalSettingPolicy;
use App\Policies\SharedDocumentPolicy;
use App\Policies\VendorPolicy;

function tenantUserAs(string $role): User
{
    $user = User::query()->create([
        'name' => $role.' Tester',
        'email' => mb_strtolower(str_replace(['/', ' '], '-', $role)).'-'.uniqid().'@test-tenant.localhost',
        'password' => bcrypt('x'),
    ]);
    $user->assignRole($role);

    return $user;
}

describe('CoursePolicy', function (): void {
    $policy = new CoursePolicy;
    $course = new CentralCourse;

    it('allows viewAny/view for super-admin and Consultant', function () use ($policy, $course): void {
        foreach (['super-admin', 'Consultant'] as $role) {
            $u = tenantUserAs($role);
            expect($policy->viewAny($u))->toBeTrue();
            expect($policy->view($u, $course))->toBeTrue();
        }
    });

    it('denies viewAny/view to Manager and Employee', function () use ($policy, $course): void {
        foreach (['Manager', 'Employee'] as $role) {
            $u = tenantUserAs($role);
            expect($policy->viewAny($u))->toBeFalse();
            expect($policy->view($u, $course))->toBeFalse();
        }
    });

    it('restricts manage/update/import to super-admin only (Consultants denied)', function () use ($policy, $course): void {
        $admin = tenantUserAs('super-admin');
        $consultant = tenantUserAs('Consultant');

        expect($policy->manage($admin))->toBeTrue();
        expect($policy->update($admin, $course))->toBeTrue();
        expect($policy->import($admin))->toBeTrue();

        expect($policy->manage($consultant))->toBeFalse();
        expect($policy->update($consultant, $course))->toBeFalse();
        expect($policy->import($consultant))->toBeFalse();
    });
});

describe('CourseResultsPolicy', function (): void {
    $policy = new CourseResultsPolicy;

    it('allows super-admin, Consultant, and Qualified Individual to reset courses', function () use ($policy): void {
        foreach (['super-admin', 'Consultant', 'Qualified Individual'] as $role) {
            expect($policy->resetCourses(tenantUserAs($role)))->toBeTrue();
        }
    });

    it('denies Manager and Employee from resetting courses', function () use ($policy): void {
        foreach (['Manager', 'Employee'] as $role) {
            expect($policy->resetCourses(tenantUserAs($role)))->toBeFalse();
        }
    });
});

describe('DealerDocPolicy', function (): void {
    $policy = new DealerDocPolicy;
    $doc = new DealerDoc;

    it('locks create/delete to Consultants only', function () use ($policy, $doc): void {
        expect($policy->create(tenantUserAs('Consultant')))->toBeTrue();
        expect($policy->delete(tenantUserAs('Consultant'), $doc))->toBeTrue();

        foreach (['super-admin', 'Manager', 'Employee'] as $role) {
            $u = tenantUserAs($role);
            expect($policy->create($u))->toBeFalse();
            expect($policy->delete($u, $doc))->toBeFalse();
        }
    });
});

describe('GlobalSettingPolicy', function (): void {
    $policy = new GlobalSettingPolicy;

    it('allows manage() only to Consultants', function () use ($policy): void {
        expect($policy->manage(tenantUserAs('Consultant')))->toBeTrue();
        expect($policy->manage(tenantUserAs('super-admin')))->toBeFalse();
        expect($policy->manage(tenantUserAs('Manager')))->toBeFalse();
        expect($policy->manage(tenantUserAs('Employee')))->toBeFalse();
    });

    it('allows manageReports for every automated-report role (Consultant, Owner, CFO, GM, GSM, QI, super-admin, Admin)', function () use ($policy): void {
        foreach (['Consultant', 'Owner', 'CFO', 'GM', 'GSM', 'Qualified Individual'] as $role) {
            expect($policy->manageReports(tenantUserAs($role)))->toBeTrue();
        }
    });

    it('denies manageReports for Manager, Employee, and Porter/Driver', function () use ($policy): void {
        foreach (['Manager', 'Employee', 'Porter/Driver'] as $role) {
            expect($policy->manageReports(tenantUserAs($role)))->toBeFalse();
        }
    });
});

describe('SharedDocumentPolicy (tenant)', function (): void {
    $policy = new SharedDocumentPolicy;
    $doc = new SharedDocument;

    it('locks every action to super-admin only', function () use ($policy, $doc): void {
        $admin = tenantUserAs('super-admin');
        expect($policy->viewAny($admin))->toBeTrue();
        expect($policy->create($admin))->toBeTrue();
        expect($policy->update($admin, $doc))->toBeTrue();
        expect($policy->delete($admin, $doc))->toBeTrue();

        foreach (['Consultant', 'Manager', 'Employee'] as $role) {
            $u = tenantUserAs($role);
            expect($policy->viewAny($u))->toBeFalse();
            expect($policy->create($u))->toBeFalse();
            expect($policy->update($u, $doc))->toBeFalse();
            expect($policy->delete($u, $doc))->toBeFalse();
        }
    });
});

describe('VendorPolicy', function (): void {
    $policy = new VendorPolicy;
    $vendor = new Vendor;

    it('allows every role EXCEPT Employee and Porter/Driver to view/create/update/delete vendors', function () use ($policy, $vendor): void {
        foreach (['super-admin', 'Consultant', 'Manager', 'Qualified Individual', 'Owner', 'CFO', 'GM', 'GSM', 'Admin'] as $role) {
            $u = tenantUserAs($role);
            expect($policy->viewAny($u))->toBeTrue();
            expect($policy->view($u, $vendor))->toBeTrue();
            expect($policy->create($u))->toBeTrue();
            expect($policy->update($u, $vendor))->toBeTrue();
            expect($policy->delete($u, $vendor))->toBeTrue();
        }
    });

    it('denies Employee and Porter/Driver from every vendor action', function () use ($policy, $vendor): void {
        foreach (['Employee', 'Porter/Driver'] as $role) {
            $u = tenantUserAs($role);
            expect($policy->viewAny($u))->toBeFalse();
            expect($policy->view($u, $vendor))->toBeFalse();
            expect($policy->create($u))->toBeFalse();
            expect($policy->update($u, $vendor))->toBeFalse();
            expect($policy->delete($u, $vendor))->toBeFalse();
        }
    });
});
