<?php

declare(strict_types=1);

use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Course as DealerCourse;
use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Invite;
use App\Models\Dealer\PhishingCampaign;
use App\Models\Dealer\Settings\EmployeeList;
use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorForm;
use App\Models\Department;
use App\Models\Sds;
use App\Models\User;
use App\Services\VimeoService;
use Illuminate\Routing\Route as IlluminateRoute;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    Storage::fake('sds-sheets');

    $this->tenant->update(['locations' => false]);

    $this->store = Store::query()->firstOrFail();
    $this->store->update(['videos' => true]);

    EmployeeList::query()->firstOrCreate([
        'store_id' => $this->store->id,
    ]);

    $this->department = Department::query()->firstOrCreate([
        'name' => 'Route Coverage Department',
    ]);

    GlobalSetting::query()->firstOrCreate([], [
        'phishing_active' => false,
        'phishing_token' => 'route-coverage-token',
        'phishing_ip' => '127.0.0.1',
    ]);

    $this->routeConsultant = User::factory()->create([
        'name' => 'Route Consultant',
        'email' => 'route-consultant@test-tenant.localhost',
        'password' => bcrypt('password'),
        'current_store_id' => $this->store->id,
    ]);
    $this->routeConsultant->assignRole('Consultant');

    $this->routeConsultant->update([
        'current_store_id' => $this->store->id,
    ]);

    $this->superAdmin = User::factory()->create([
        'name' => 'Route Super Admin',
        'email' => 'route-super-admin@test-tenant.localhost',
        'password' => bcrypt('password'),
        'current_store_id' => $this->store->id,
    ]);
    $this->superAdmin->assignRole('super-admin');

    $this->employee = User::factory()->create([
        'name' => 'Route Employee',
        'email' => 'route-employee@test-tenant.localhost',
        'password' => bcrypt('password'),
        'current_store_id' => $this->store->id,
    ]);
    $this->employee->assignRole('Employee');
    $this->employee->stores()->sync([$this->store->id]);

    $this->manager->update([
        'current_store_id' => $this->store->id,
    ]);
    $this->manager->stores()->sync([$this->store->id]);

    Permission::query()->firstOrCreate(['name' => 'impersonate-users']);

    $this->routeConsultant->givePermissionTo(['delete-stores', 'impersonate-users']);
    $this->superAdmin->givePermissionTo(['impersonate-users']);

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    $vimeoService = $this->mock(VimeoService::class);
    $vimeoService->shouldReceive('getVideo')->andReturn([
        'title' => 'Route Coverage Video',
        'player_embed_url' => 'https://player.vimeo.com/video/12345',
    ]);
    $vimeoService->shouldReceive('getVideos')->andReturn([]);
    $vimeoService->shouldReceive('getCategories')->andReturn([]);

    $this->oshaAudit = OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->routeConsultant->id,
        'store_id' => $this->store->id,
        'date' => now()->toDateString(),
    ]);

    $this->bodyShopAudit = BodyShopViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->routeConsultant->id,
        'store_id' => $this->store->id,
        'date' => now()->toDateString(),
    ]);

    $this->glbaAudit = GlbaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->routeConsultant->id,
        'store_id' => $this->store->id,
        'date' => now()->toDateString(),
    ]);

    $this->individualAudit = IndividualAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->routeConsultant->id,
        'store_id' => $this->store->id,
        'audit_date' => now()->toDateString(),
        'deal_jacket_date' => now()->toDateString(),
        'draft' => true,
    ]);

    $this->dealJacketGroup = DealJacketGroup::factory()->create([
        'store_id' => $this->store->id,
    ]);

    $this->dealJacket = DealJacket::factory()->create([
        'deal_jacket_group_id' => $this->dealJacketGroup->id,
        'user_id' => $this->routeConsultant->id,
    ]);

    $this->phishingCampaign = PhishingCampaign::query()->create([
        'campaign_id' => 'campaign-route-1',
        'user_id' => $this->routeConsultant->id,
        'store_id' => $this->store->id,
        'name' => 'Route Coverage Campaign',
        'status' => 'In progress',
        'campaign_created_at' => now(),
    ]);

    $this->vendor = Vendor::query()->create([
        'name' => 'Route Coverage Vendor',
        'contact_name' => 'Vendor Contact',
        'contact_email' => 'vendor-contact@test-tenant.localhost',
        'store_id' => $this->store->id,
    ]);

    $this->vendorForm = VendorForm::query()->create([
        'vendor_id' => $this->vendor->id,
        'name' => 'Vendor Form Contact',
        'email' => 'vendor-form@test-tenant.localhost',
    ]);

    $this->activity = activity()
        ->causedBy($this->routeConsultant)
        ->log('tenant route coverage activity');

    $this->dealJacketReportFile = 'deal-jacket-route-coverage.pdf';
    Storage::put('deal-jacket-reports/'.$this->dealJacketReportFile, 'pdf-content');

    [$this->sdsUuid, $this->sdsFileName] = tenancy()->central(function (): array {
        $fileName = 'route-coverage-sds.pdf';

        Storage::disk('sds-sheets')->put($fileName, 'pdf-content');

        $sds = Sds::query()->create([
            'name' => 'Route Coverage SDS',
            'manufacturer' => 'Route Coverage Manufacturer',
            'keywords' => ['route', 'coverage'],
            'file_name' => $fileName,
        ]);

        return [$sds->uuid, $fileName];
    });
});

function dealerNamedRoutes(): Collection
{
    return collect(Route::getRoutes())
        ->filter(function (IlluminateRoute $route): bool {
            $name = $route->getName();

            return is_string($name)
                && str_starts_with($name, 'dealer.')
                && $name !== 'dealer.';
        })
        ->sortBy(fn (IlluminateRoute $route): string => (string) $route->getName())
        ->values();
}

function dealerUnnamedRoutes(): Collection
{
    return collect(Route::getRoutes())
        ->filter(fn (IlluminateRoute $route): bool => $route->getName() === 'dealer.')
        ->values();
}

function firstHttpMethod(IlluminateRoute $route): string
{
    $methods = collect($route->methods())->reject(fn (string $method): bool => $method === 'HEAD')->values();

    return (string) $methods->first();
}

function routeHasMiddleware(IlluminateRoute $route, string $needle): bool
{
    return collect($route->gatherMiddleware())
        ->contains(fn (string $middleware): bool => str_contains($middleware, $needle));
}

function routeHasExactMiddleware(IlluminateRoute $route, string $needle): bool
{
    return collect($route->gatherMiddleware())
        ->contains(fn (string $middleware): bool => $middleware === $needle);
}

function namedRouteParameters(object $test, string $routeName): array
{
    return match ($routeName) {
        'dealer.audit.body-shop.create' => ['store' => $test->store->id],
        'dealer.audit.body-shop.edit' => ['bodyShopViolationAudit' => $test->bodyShopAudit->uuid],
        'dealer.audit.body-shop.remediation' => ['bodyShopViolationAudit' => $test->bodyShopAudit->uuid],
        'dealer.audit.body-shop.show' => ['bodyShopViolationAudit' => $test->bodyShopAudit->uuid],

        'dealer.audit.deal-jacket-reports.download' => ['fileName' => $test->dealJacketReportFile],
        'dealer.audit.deal-jackets.create' => ['dealJacketGroup' => $test->dealJacketGroup->uuid],
        'dealer.audit.deal-jackets.edit' => [
            'dealJacketGroup' => $test->dealJacketGroup->uuid,
            'dealJacket' => $test->dealJacket->uuid,
        ],
        'dealer.audit.deal-jackets.show' => ['dealJacketGroup' => $test->dealJacketGroup->uuid],
        'dealer.audit.deal-jackets.single' => [
            'dealJacketGroup' => $test->dealJacketGroup->uuid,
            'dealJacket' => $test->dealJacket->uuid,
        ],

        'dealer.audit.finance.create' => ['store' => $test->store->id],
        'dealer.audit.finance.edit' => ['glbaViolationAudit' => $test->glbaAudit->uuid],
        'dealer.audit.finance.remediation' => ['glbaViolationAudit' => $test->glbaAudit->uuid],
        'dealer.audit.finance.show' => ['glbaViolationAudit' => $test->glbaAudit->uuid],

        'dealer.audit.individual.create' => ['individualAudit' => $test->individualAudit->id],
        'dealer.audit.individual.edit' => ['individualAudit' => $test->individualAudit->uuid],
        'dealer.audit.individual.show' => ['individualAudit' => $test->individualAudit->uuid],

        'dealer.audit.osha.create' => ['store' => $test->store->id],
        'dealer.audit.osha.edit' => ['oshaViolationAudit' => $test->oshaAudit->uuid],
        'dealer.audit.osha.remediation' => ['oshaViolationAudit' => $test->oshaAudit->uuid],
        'dealer.audit.osha.show' => ['oshaViolationAudit' => $test->oshaAudit->uuid],

        'dealer.courses.edit' => ['course' => coverageCourse($test)->slug],
        'dealer.courses.quiz' => ['course' => coverageCourse($test)->slug],
        'dealer.courses.results.store' => ['course' => coverageCourse($test)->slug],
        'dealer.courses.show' => ['course' => coverageCourse($test)->slug],

        'dealer.employee.impersonate' => ['user' => $test->employee->id],
        'dealer.employees.create' => ['invite' => Invite::query()->create([
            'name' => 'Invite Route User',
            'email' => 'invite-create-'.Str::random(6).'@test-tenant.localhost',
            'stores' => [$test->store->id],
            'department_id' => $test->department->id,
            'user_id' => $test->routeConsultant->id,
            'roles' => ['Employee'],
            'invitation_token' => Str::random(32),
            'courses' => [],
        ])->invitation_token],
        'dealer.employees.show' => ['user' => $test->employee->slug],
        'dealer.employees.show.manage-courses' => ['user' => $test->employee->slug],

        'dealer.impersonate.token' => ['token' => tenancy()->impersonate(
            tenant(),
            $test->employee->id,
            '/dashboard',
            'web',
        )->token],

        'dealer.logs.show' => ['activity' => $test->activity->id],

        'dealer.phishing.show' => ['phishingCampaign' => $test->phishingCampaign->id],

        'dealer.password.reset' => ['token' => 'route-coverage-token'],

        'dealer.scan.report' => ['type' => 'executive'],

        'dealer.sds.view' => ['uuid' => $test->sdsUuid],

        default => [],
    };
}

function namedRoutePayload(object $test, string $routeName): array
{
    return match ($routeName) {
        'dealer.courses.results.store' => [
            'question' => [1 => 'a'],
        ],

        'dealer.employees.store' => (function () use ($test): array {
            $invite = Invite::query()->create([
                'name' => 'Invite Store User',
                'email' => 'invite-store-'.Str::random(6).'@test-tenant.localhost',
                'stores' => [$test->store->id],
                'department_id' => $test->department->id,
                'user_id' => $test->routeConsultant->id,
                'roles' => ['Employee'],
                'invitation_token' => Str::random(32),
                'courses' => [],
            ]);

            return [
                'id' => $invite->id,
                'password' => 'super-strong-pass',
                'password_confirmation' => 'super-strong-pass',
            ];
        })(),

        'dealer.password.email' => [
            'email' => $test->routeConsultant->email,
        ],

        'dealer.password.store' => [
            'token' => 'invalid-token',
            'email' => $test->routeConsultant->email,
            'password' => 'super-strong-pass',
            'password_confirmation' => 'super-strong-pass',
        ],

        'dealer.password.update' => [
            'current_password' => 'incorrect-password',
            'password' => 'new-password123',
            'password_confirmation' => 'new-password123',
        ],

        'dealer.profile.update' => [
            'name' => 'Updated Route Name',
            'email' => 'updated-route-'.Str::random(6).'@test-tenant.localhost',
        ],

        default => [],
    };
}

function coverageCourse(object $test): DealerCourse
{
    if (isset($test->routeCoverageCourse) && $test->routeCoverageCourse instanceof DealerCourse && $test->routeCoverageCourse->exists) {
        return $test->routeCoverageCourse;
    }

    $test->routeCoverageCourse = DealerCourse::query()->create([
        'slug' => 'route-coverage-course-'.Str::lower(Str::random(6)),
        'name' => 'Route Coverage Course',
        'slides' => [[
            'title' => 'Slide 1',
            'description' => 'Route coverage slide description.',
        ]],
        'questions' => [[
            'question' => 'Is route coverage enabled?',
            'answers' => [['a' => 'Yes', 'b' => 'No']],
            'correctAnswer' => 'a',
        ]],
    ]);

    return $test->routeCoverageCourse;
}

function actorForNamedRoute(object $test, IlluminateRoute $route, bool $consultantMode): ?User
{
    $route->getName();

    $isSuperAdminOnly = routeHasExactMiddleware($route, 'role:super-admin');

    if ($isSuperAdminOnly) {
        return $consultantMode ? null : $test->superAdmin;
    }

    if (routeHasMiddleware($route, 'can:delete-stores')) {
        return $consultantMode ? $test->routeConsultant : $test->superAdmin;
    }

    if (routeHasMiddleware($route, 'auth') || routeHasMiddleware($route, 'role:')) {
        return $consultantMode ? $test->routeConsultant : $test->superAdmin;
    }

    return null;
}

function assertResponseHealthy(string $routeName, int $status): void
{
    throw_if($status >= 500, RuntimeException::class, "{$routeName} returned server error status {$status}.");

    expect($status)
        ->toBeLessThan(500);

    $allowedNotFound = ['dealer.scan.report'];

    if (! in_array($routeName, $allowedNotFound, true)) {
        expect($status)
            ->not->toBe(404);
    }
}

function responseStatus(mixed $response): int
{
    if ($response instanceof TestResponse) {
        return $response->getStatusCode();
    }

    if (is_object($response) && method_exists($response, 'getStatusCode')) {
        /** @var int $statusCode */
        $statusCode = $response->getStatusCode();

        return $statusCode;
    }

    throw new RuntimeException('Unable to determine response status code.');
}

it('smoke tests every named dealer tenant route as super-admin', function (): void {
    $routes = dealerNamedRoutes();

    expect($routes)->not->toBeEmpty();

    foreach ($routes as $route) {
        $name = (string) $route->getName();

        $method = firstHttpMethod($route);
        $actor = actorForNamedRoute($this, $route, consultantMode: false);

        if (routeHasMiddleware($route, 'role:super-admin') && ! $actor instanceof User) {
            continue;
        }

        $params = namedRouteParameters($this, $name);
        $payload = namedRoutePayload($this, $name);

        $url = routeHasMiddleware($route, 'signed')
            ? URL::signedRoute($name, array_merge($params, match ($name) {
                'dealer.dealer.settings.form' => ['store' => $this->store->id],
                'dealer.vendor.create' => ['id' => $this->vendor->id],
                'dealer.vendor.form' => ['vid' => $this->vendorForm->id],
                default => [],
            }))
            : route($name, $params);

        if ($actor instanceof User) {
            $this->actingAs($actor);
        }

        $response = match ($method) {
            'GET' => $this->get($url),
            'POST' => $this->post($url, $payload),
            'PUT' => $this->put($url, $payload),
            'PATCH' => $this->patch($url, $payload),
            'DELETE' => $this->delete($url, $payload),
            default => throw new RuntimeException("Unsupported HTTP method [{$method}] for [{$name}]."),
        };

        assertResponseHealthy($name, responseStatus($response));
    }
});

it('smoke tests consultant access for non super-admin-only named dealer routes', function (): void {
    $routes = dealerNamedRoutes();

    foreach ($routes as $route) {
        $name = (string) $route->getName();

        if (routeHasExactMiddleware($route, 'role:super-admin')) {
            continue;
        }

        $method = firstHttpMethod($route);
        $actor = actorForNamedRoute($this, $route, consultantMode: true);
        $params = namedRouteParameters($this, $name);
        $payload = namedRoutePayload($this, $name);

        $url = routeHasMiddleware($route, 'signed')
            ? URL::signedRoute($name, array_merge($params, match ($name) {
                'dealer.dealer.settings.form' => ['store' => $this->store->id],
                'dealer.vendor.create' => ['id' => $this->vendor->id],
                'dealer.vendor.form' => ['vid' => $this->vendorForm->id],
                default => [],
            }))
            : route($name, $params);

        if ($actor instanceof User) {
            $this->actingAs($actor);
        }

        $response = match ($method) {
            'GET' => $this->get($url),
            'POST' => $this->post($url, $payload),
            'PUT' => $this->put($url, $payload),
            'PATCH' => $this->patch($url, $payload),
            'DELETE' => $this->delete($url, $payload),
            default => throw new RuntimeException("Unsupported HTTP method [{$method}] for [{$name}]."),
        };

        assertResponseHealthy($name, responseStatus($response));
    }
});

it('enforces elevated route limitations for manager and employee roles', function (): void {
    $restrictedRoutes = [
        'dealer.settings.global' => [],
        'dealer.settings.global.reset-courses' => [],
        'dealer.audit.osha.create' => ['store' => $this->store->id],
        'dealer.audit.body-shop.create' => ['store' => $this->store->id],
        'dealer.audit.finance.create' => ['store' => $this->store->id],
        'dealer.audit.individual.create' => ['individualAudit' => $this->individualAudit->id],
        'dealer.phishing.create' => [],
        'dealer.ridgeback.index' => [],
    ];

    foreach ($restrictedRoutes as $routeName => $params) {
        $this->actingAs($this->manager)
            ->get(route($routeName, $params))
            ->assertForbidden();

        $this->actingAs($this->employee)
            ->get(route($routeName, $params))
            ->assertForbidden();
    }
});

it('smoke tests unnamed dealer routes from tenant routes file', function (): void {
    $routes = dealerUnnamedRoutes();

    expect($routes)->not->toBeEmpty();

    foreach ($routes as $route) {
        $method = firstHttpMethod($route);
        $uri = $route->uri();

        $url = '/'.$uri;

        if (str_contains((string) $uri, '{locale}')) {
            $url = '/'.str_replace('{locale}', 'en', $uri);
        }

        if ($method === 'POST' && $uri === 'login') {
            $response = $this->post($url, [
                'email' => $this->routeConsultant->email,
                'password' => 'password',
            ]);
        } elseif ($method === 'POST' && $uri === 'confirm-password') {
            $response = $this->actingAs($this->routeConsultant)
                ->post($url, [
                    'password' => 'password',
                ]);
        } elseif (routeHasMiddleware($route, 'auth')) {
            $response = $this->actingAs($this->routeConsultant)->{$method === 'GET' ? 'get' : 'post'}($url);
        } else {
            $response = $method === 'GET' ? $this->get($url) : $this->post($url);
        }

        $status = responseStatus($response);

        expect($status)
            ->toBeLessThan(500);
    }
});

it('covers the tenant gophish webhook route', function (): void {
    $campaign = PhishingCampaign::query()->create([
        'campaign_id' => 'campaign-route-webhook',
        'user_id' => $this->routeConsultant->id,
        'store_id' => $this->store->id,
        'name' => 'Webhook Campaign',
        'status' => 'In progress',
        'campaign_created_at' => now(),
    ]);

    $this->postJson(route('webhooks.gophish'), [
        'campaign_id' => $campaign->campaign_id,
        'email' => 'employee@test-tenant.localhost',
        'time' => now()->toIso8601String(),
        'message' => 'Email Sent',
        'details' => 'Webhook route coverage event',
    ])
        ->assertOk()
        ->assertJson(['status' => 'success']);

    $this->assertDatabaseHas('timelines', [
        'phishing_campaign_id' => $campaign->id,
        'message' => 'Email Sent',
    ]);
});
