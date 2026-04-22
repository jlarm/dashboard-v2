<?php

declare(strict_types=1);

use App\Models\Central\UserInvite;
use App\Models\Contract;
use App\Models\Course;
use App\Models\Document;
use App\Models\Sds;
use App\Models\SharedDocument;
use App\Models\User;
use App\Models\ViolationStatement;
use App\Services\VimeoService;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\URL;
use Mockery\MockInterface;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

beforeEach(function (): void {
    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    $this->mock(VimeoService::class, function (MockInterface $mock): void {
        $mock->shouldReceive('getVideo')->andReturn(null);
    });
});

function asRole(string $role): TestCase
{
    $user = User::factory()->create([
        'email' => uniqid('user_', true).'@example.test',
    ]);
    $user->assignRole($role);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    return test()->actingAs($user);
}

/**
 * Interpret an expected response status.
 *  - ok: 200
 *  - redirect: 302/303 (e.g. store succeeded, or validation failed)
 *  - blocked: 302/403 (role gate rejected the request — either via policy 403 or via validation 302)
 *  - forbidden: 403
 */
function expectStatus($response, string $expected): void
{
    match ($expected) {
        'ok' => $response->assertOk(),
        'redirect' => expect($response->getStatusCode())->toBeIn([302, 303]),
        'blocked' => expect($response->getStatusCode())->toBeIn([302, 403]),
        'forbidden' => $response->assertForbidden(),
    };
}

/**
 * Routes under the auth+verified+role:super-admin|Consultant middleware group.
 * Tuple: [method, route_name, super-admin expected, Consultant expected].
 */
dataset('sharedRoutes', [
    'GET dashboard' => ['get', 'dashboard', 'ok', 'ok'],
    'GET dealerships.index' => ['get', 'dealerships.index', 'ok', 'ok'],
    'POST dealerships.store' => ['post', 'dealerships.store', 'redirect', 'redirect'],
    'GET courses.index' => ['get', 'courses.index', 'ok', 'ok'],
    'GET documents.index' => ['get', 'documents.index', 'ok', 'ok'],
    'POST documents.store' => ['post', 'documents.store', 'redirect', 'blocked'],
    'GET shared-documents.index' => ['get', 'shared-documents.index', 'ok', 'ok'],
    'POST shared-documents.store' => ['post', 'shared-documents.store', 'redirect', 'blocked'],
    'GET contracts.index' => ['get', 'contracts.index', 'ok', 'ok'],
    'GET contracts.create' => ['get', 'contracts.create', 'ok', 'ok'],
    'GET sds.index' => ['get', 'sds.index', 'ok', 'ok'],
    'POST sds.store' => ['post', 'sds.store', 'redirect', 'blocked'],
    'GET violation-statements.index' => ['get', 'violation-statements.index', 'ok', 'ok'],
    'POST violation-statements.store' => ['post', 'violation-statements.store', 'redirect', 'blocked'],
]);

/**
 * Routes under the role:super-admin only middleware group.
 */
dataset('superAdminRoutes', [
    'GET course-management.index' => ['get', 'course-management.index'],
    'POST course-management.import' => ['post', 'course-management.import'],
    'GET employees.index' => ['get', 'employees.index'],
    'GET employees.invites' => ['get', 'employees.invites'],
    'POST employees.invites.store' => ['post', 'employees.invites.store'],
    'GET employees.deleted' => ['get', 'employees.deleted'],
]);

describe('shared (super-admin + Consultant) routes', function (): void {
    it('allows super-admin', function (string $method, string $route, string $superExpect, string $consultantExpect): void {
        $response = asRole('super-admin')->{$method}(route($route));

        expectStatus($response, $superExpect);
    })->with('sharedRoutes');

    it('allows Consultant', function (string $method, string $route, string $superExpect, string $consultantExpect): void {
        $response = asRole('Consultant')->{$method}(route($route));

        expectStatus($response, $consultantExpect);
    })->with('sharedRoutes');

    it('forbids unprivileged roles', function (string $method, string $route): void {
        foreach (['Manager', 'Employee', 'Owner', 'GM', 'CFO', 'Qualified Individual'] as $role) {
            asRole($role)
                ->{$method}(route($route))
                ->assertForbidden();
        }
    })->with('sharedRoutes');

    it('redirects guests to login for GET routes', function (string $method, string $route): void {
        $response = test()->{$method}(route($route));

        if ($method === 'get') {
            $response->assertRedirect(route('login'));
        } else {
            expect($response->getStatusCode())->toBeIn([302, 401, 403]);
        }
    })->with('sharedRoutes');
});

describe('super-admin-only routes', function (): void {
    it('allows super-admin', function (string $method, string $route): void {
        $response = asRole('super-admin')->{$method}(route($route));

        expect($response->getStatusCode())->toBeIn([200, 302, 303]);
    })->with('superAdminRoutes');

    it('forbids Consultant', function (string $method, string $route): void {
        asRole('Consultant')
            ->{$method}(route($route))
            ->assertForbidden();
    })->with('superAdminRoutes');

    it('forbids unprivileged roles', function (string $method, string $route): void {
        foreach (['Manager', 'Employee', 'Owner'] as $role) {
            asRole($role)
                ->{$method}(route($route))
                ->assertForbidden();
        }
    })->with('superAdminRoutes');

    it('redirects guests from GET super-admin-only routes to login', function (string $method, string $route): void {
        $response = test()->{$method}(route($route));

        if ($method === 'get') {
            $response->assertRedirect(route('login'));
        } else {
            expect($response->getStatusCode())->toBeIn([302, 401, 403]);
        }
    })->with('superAdminRoutes');
});

describe('model-bound shared routes', function (): void {
    it('allows super-admin to load a course show page', function (): void {
        $course = Course::factory()->create();

        asRole('super-admin')->get(route('courses.show', $course))->assertOk();
    });

    it('allows Consultant to load a course show page', function (): void {
        $course = Course::factory()->create();

        asRole('Consultant')->get(route('courses.show', $course))->assertOk();
    });

    it('forbids unprivileged users from a course show page', function (): void {
        $course = Course::factory()->create();

        asRole('Employee')->get(route('courses.show', $course))->assertForbidden();
    });

    it('redirects guests from a course show page to login', function (): void {
        $course = Course::factory()->create();

        test()->get(route('courses.show', $course))->assertRedirect(route('login'));
    });

    it('allows super-admin to open a contract edit page', function (): void {
        $contract = Contract::factory()->create(['armp_signature' => null]);

        asRole('super-admin')->get(route('contracts.edit', $contract))->assertOk();
    });

    it('forbids non-owner Consultants from a contract edit page', function (): void {
        $contract = Contract::factory()->create(['armp_signature' => null]);

        asRole('Consultant')->get(route('contracts.edit', $contract))->assertForbidden();
    });

    it('forbids unprivileged users from every contract mutation', function (): void {
        $contract = Contract::factory()->create(['armp_signature' => null, 'dealer_signature' => null]);

        asRole('Employee')->get(route('contracts.edit', $contract))->assertForbidden();
        asRole('Employee')->patch(route('contracts.update', $contract))->assertForbidden();
        asRole('Employee')->delete(route('contracts.destroy', $contract))->assertForbidden();
        asRole('Employee')->post(route('contracts.send', $contract), ['emails' => ['a@b.test']])->assertForbidden();
        asRole('Employee')->post(route('contracts.pdf.generate', $contract))->assertForbidden();
        asRole('Employee')->get(route('contracts.pdf.download', $contract))->assertForbidden();
        asRole('Employee')->post(route('contracts.pdf.send', $contract))->assertForbidden();
    });

    it('forbids unprivileged users from every SDS mutation', function (): void {
        $sds = Sds::factory()->create();

        asRole('Employee')->patch(route('sds.update', $sds))->assertForbidden();
        asRole('Employee')->delete(route('sds.destroy', $sds))->assertForbidden();
        asRole('Employee')->get(route('sds.download', $sds))->assertForbidden();
    });

    it('forbids unprivileged users from every document mutation', function (): void {
        $document = Document::factory()->create();

        asRole('Employee')->delete(route('documents.destroy', $document))->assertForbidden();
        asRole('Employee')->get(route('documents.download', $document))->assertForbidden();
    });

    it('forbids unprivileged users from every shared-document mutation', function (): void {
        $shared = SharedDocument::factory()->create();

        asRole('Employee')->delete(route('shared-documents.destroy', $shared))->assertForbidden();
        asRole('Employee')->get(route('shared-documents.download', $shared))->assertForbidden();
    });

    it('forbids unprivileged users from every violation-statement mutation', function (): void {
        $statement = ViolationStatement::factory()->create();

        asRole('Employee')->patch(route('violation-statements.update', $statement))->assertForbidden();
        asRole('Employee')->delete(route('violation-statements.destroy', $statement))->assertForbidden();
    });

    it('forbids unprivileged users from course video-progress and quiz submission', function (): void {
        $course = Course::factory()->create();

        asRole('Employee')->post(route('courses.progress.store', $course))->assertForbidden();
        asRole('Employee')->post(route('courses.quiz.store', $course), ['question' => ['A']])->assertForbidden();
    });
});

describe('model-bound super-admin-only routes', function (): void {
    it('forbids Consultants from every course-management mutation', function (): void {
        $course = Course::factory()->create();

        asRole('Consultant')->get(route('course-management.edit', $course))->assertForbidden();
        asRole('Consultant')->patch(route('course-management.update', $course))->assertForbidden();
        asRole('Consultant')->patch(route('course-management.update-quiz', $course))->assertForbidden();
        asRole('Consultant')->patch(route('course-management.update-settings', $course))->assertForbidden();
    });

    it('forbids Consultants from employee records and invite revocation', function (): void {
        $employee = User::factory()->create();
        $employee->assignRole('Consultant');

        $invite = UserInvite::factory()->create();

        asRole('Consultant')->get(route('employees.show', ['user' => $employee->slug]))->assertForbidden();
        asRole('Consultant')->delete(route('employees.invites.destroy', ['invite' => $invite]))->assertForbidden();
    });

    it('redirects guests from super-admin-only GET model-bound routes to login', function (): void {
        $course = Course::factory()->create();
        $employee = User::factory()->create();

        test()->get(route('course-management.edit', $course))->assertRedirect(route('login'));
        test()->get(route('employees.show', ['user' => $employee->slug]))->assertRedirect(route('login'));
    });
});

describe('public and signed-only routes', function (): void {
    it('renders the home welcome page for guests', function (): void {
        test()->get(route('home'))->assertOk();
    });

    it('renders the contract thank-you page without auth', function (): void {
        test()->get(route('contracts.thank-you'))->assertOk();
    });

    it('forbids unsigned access to the contract review show route', function (): void {
        $contract = Contract::factory()->create();

        test()->get(route('contracts.show', $contract))->assertForbidden();
    });

    it('forbids unsigned access to the invite registration routes', function (): void {
        $invite = UserInvite::factory()->create();

        test()->get(route('employees.create', ['centralUserInvite' => $invite->id]))->assertForbidden();
        test()->post(route('employees.store', ['centralUserInvite' => $invite->id]))->assertForbidden();
    });

    it('redirects authenticated users away from the guest-only invite registration', function (): void {
        $invite = UserInvite::factory()->create();

        $signed = URL::temporarySignedRoute(
            'employees.create',
            $invite->expires_at,
            ['centralUserInvite' => $invite->id],
        );

        asRole('super-admin')->get($signed)->assertRedirect();
    });
});
