<?php

declare(strict_types=1);

use App\Models\AuditComment;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Course as DealerCourse;
use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Invite;
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
    Illuminate\Support\Facades\Bus::fake();
    Illuminate\Support\Facades\Queue::fake();
    Illuminate\Support\Facades\Notification::fake();
    Storage::fake('sds-sheets');
    Storage::fake('do-audits');
    Storage::fake('do-manuals');
    Storage::fake('dealer-docs');
    Storage::fake('central-docs');

    // PDF dispatchers instantiate heavy jobs in their constructors. The smoke
    // test only verifies route + middleware wiring, so swap them for no-ops.
    $this->mock(App\Domain\Tenant\Audits\Actions\DispatchAuditPdfGeneration::class)
        ->shouldReceive('handle')->andReturnNull()->byDefault();
    $this->mock(App\Domain\Tenant\Audits\Actions\DispatchRemediationPdfGeneration::class)
        ->shouldReceive('handle')->andReturnNull()->byDefault();
    $this->mock(App\Domain\Tenant\IndividualAudits\Actions\DispatchIndividualAuditPdfGeneration::class)
        ->shouldReceive('handle')->andReturnNull()->byDefault();

    $this->tenant->update(['locations' => false]);

    $this->store = Store::query()->firstOrFail();
    $this->store->update(['videos' => true]);

    EmployeeList::query()->firstOrCreate([
        'store_id' => $this->store->id,
    ]);

    $this->department = Department::query()->firstOrCreate([
        'name' => 'Route Coverage Department',
    ]);

    GlobalSetting::query()->firstOrCreate([]);

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

    $this->oshaComment = AuditComment::query()->create([
        'user_id' => $this->routeConsultant->id,
        'auditable_id' => $this->oshaAudit->id,
        'auditable_type' => OshaViolationAudit::class,
        'comment' => 'Route coverage osha comment.',
    ]);

    $this->bodyShopComment = AuditComment::query()->create([
        'user_id' => $this->routeConsultant->id,
        'auditable_id' => $this->bodyShopAudit->id,
        'auditable_type' => BodyShopViolationAudit::class,
        'comment' => 'Route coverage body-shop comment.',
    ]);

    $this->glbaComment = AuditComment::query()->create([
        'user_id' => $this->routeConsultant->id,
        'auditable_id' => $this->glbaAudit->id,
        'auditable_type' => GlbaViolationAudit::class,
        'comment' => 'Route coverage glba comment.',
    ]);

    $this->oshaViolation = $this->oshaAudit->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => 0,
        'statement' => 'Route coverage osha violation.',
        'risk' => false,
    ]);

    $this->bodyShopViolation = $this->bodyShopAudit->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => 0,
        'statement' => 'Route coverage body-shop violation.',
        'risk' => false,
    ]);

    $this->glbaViolation = $this->glbaAudit->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => 0,
        'statement' => 'Route coverage glba violation.',
        'risk' => false,
    ]);

    $this->individualAudit = IndividualAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->routeConsultant->id,
        'store_id' => $this->store->id,
        'audit_date' => now()->toDateString(),
        'deal_jacket_date' => now()->toDateString(),
        'draft' => true,
        'pdf_path' => 'route-coverage-individual.pdf',
    ]);

    $this->dealJacketGroup = DealJacketGroup::factory()->create([
        'store_id' => $this->store->id,
    ]);

    $this->dealJacket = DealJacket::factory()->create([
        'deal_jacket_group_id' => $this->dealJacketGroup->id,
        'user_id' => $this->routeConsultant->id,
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
        'document_path' => 'route-coverage-vendor-form.pdf',
    ]);
    Storage::disk('do-manuals')->put('route-coverage-vendor-form.pdf', 'pdf-content');

    $this->dealerDoc = App\Models\DealerDoc::query()->create([
        'title' => 'Route Coverage Doc',
        'store_id' => $this->store->id,
        'file_name' => 'route-coverage-doc.pdf',
        'file_path' => 'route-coverage-doc.pdf',
    ]);
    Storage::disk('dealer-docs')->put('route-coverage-doc.pdf', 'pdf-content');

    $this->sharedDocument = tenancy()->central(function (): App\Models\SharedDocument {
        Storage::disk('central-docs')->put('route-coverage-shared.pdf', 'pdf-content');

        return App\Models\SharedDocument::query()->create([
            'title' => 'Route Coverage Shared',
            'file_name' => 'route-coverage-shared.pdf',
        ]);
    });

    $this->fitTestDoc = App\Models\FitTestDoc::query()->create([
        'store_id' => $this->store->id,
        'user_id' => $this->routeConsultant->id,
        'employee_name' => 'Route Coverage Employee',
        'date' => now()->toDateString(),
        'file_path' => 'route-coverage-fit-test.pdf',
    ]);
    Storage::disk('dealer-docs')->put('route-coverage-fit-test.pdf', 'pdf-content');

    $tenantId = tenant('id');

    $this->oshaManual = App\Models\Dealer\Manual\Osha::query()->create([
        'store_id' => $this->store->id,
        'user_id' => $this->routeConsultant->id,
        'pdf_path' => 'route-coverage-osha-manual.pdf',
    ]);
    Storage::disk('do-manuals')->put("{$tenantId}/osha/route-coverage-osha-manual.pdf", 'pdf-content');

    $this->ispManual = App\Models\Dealer\Manual\Isp::query()->create([
        'store_id' => $this->store->id,
        'user_id' => $this->routeConsultant->id,
        'pdf_path' => 'route-coverage-isp-manual.pdf',
    ]);
    Storage::disk('do-manuals')->put("{$tenantId}/isp/route-coverage-isp-manual.pdf", 'pdf-content');

    $this->redFlagManual = App\Models\Dealer\Manual\RedFlag::query()->create([
        'store_id' => $this->store->id,
        'user_id' => $this->routeConsultant->id,
        'pdf_path' => 'route-coverage-red-flag-manual.pdf',
    ]);
    Storage::disk('do-manuals')->put("{$tenantId}/red-flags/route-coverage-red-flag-manual.pdf", 'pdf-content');

    $this->cmsManual = App\Models\CmsManual::query()->create([
        'store_id' => $this->store->id,
        'user_id' => $this->routeConsultant->id,
        'qi_name' => 'Route Coverage QI',
        'standard_dpp_rate' => 1.00,
        'acknowledgement_name' => 'Route Coverage Ack',
        'acknowledgement_signature' => 'route-coverage-ack-signature.png',
        'pdf_path' => 'route-coverage-cms-manual.pdf',
    ]);
    Storage::disk('do-manuals')->put("{$tenantId}/cms/route-coverage-cms-manual.pdf", 'pdf-content');

    $this->consultantNotification = $this->routeConsultant->notifications()->create([
        'id' => (string) Str::uuid(),
        'type' => 'route-coverage',
        'data' => ['message' => 'Route coverage notification'],
    ]);

    $this->superAdminNotification = $this->superAdmin->notifications()->create([
        'id' => (string) Str::uuid(),
        'type' => 'route-coverage',
        'data' => ['message' => 'Route coverage notification'],
    ]);

    $this->deletedEmployee = User::factory()->create([
        'name' => 'Route Deleted Employee',
        'email' => 'route-deleted-employee@test-tenant.localhost',
        'password' => bcrypt('password'),
    ]);
    $this->deletedEmployee->assignRole('Employee');
    $this->deletedEmployee->stores()->sync([$this->store->id]);
    $this->deletedEmployee->delete();

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
        ->sortBy(function (IlluminateRoute $route): string {
            $name = (string) $route->getName();
            // Run destructive routes after their non-destructive siblings so a
            // delete doesn't 404 every later read against the same fixture.
            $isDestructive = str_ends_with($name, '.destroy') || str_ends_with($name, '.destroy-group');

            return ($isDestructive ? '2' : '1').$name;
        })
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

function violationAuditRouteParams(object $test, string $type, string $action): array
{
    $audit = match ($type) {
        'body-shop' => $test->bodyShopAudit,
        'osha' => $test->oshaAudit,
        'finance' => $test->glbaAudit,
    };

    $comment = match ($type) {
        'body-shop' => $test->bodyShopComment,
        'osha' => $test->oshaComment,
        'finance' => $test->glbaComment,
    };

    $violation = match ($type) {
        'body-shop' => $test->bodyShopViolation,
        'osha' => $test->oshaViolation,
        'finance' => $test->glbaViolation,
    };

    if ($action === 'create') {
        return ['store' => $test->store->id];
    }

    if ($action === 'index') {
        return [];
    }

    return match ($action) {
        'comments.update', 'comments.destroy' => ['audit' => $audit->uuid, 'comment' => $comment->id],
        'violations.destroy' => ['audit' => $audit->uuid, 'violation' => $violation->id],
        'violations.photos.destroy' => ['audit' => $audit->uuid, 'violation' => $violation->id, 'photoId' => 1],
        default => ['audit' => $audit->uuid],
    };
}

function namedRouteParameters(object $test, string $routeName, ?User $actor = null): array
{
    $notification = $actor === $test->superAdmin
        ? $test->superAdminNotification
        : $test->consultantNotification;

    if (preg_match('/^dealer\.audit\.(body-shop|osha|finance)\.(.+)$/', $routeName, $matches) === 1) {
        return violationAuditRouteParams($test, $matches[1], $matches[2]);
    }

    return match ($routeName) {
        'dealer.audit.deal-jacket-reports.download' => ['fileName' => $test->dealJacketReportFile],
        'dealer.audit.deal-jackets.complete' => ['dealJacketGroup' => $test->dealJacketGroup->uuid],
        'dealer.audit.deal-jackets.create' => ['dealJacketGroup' => $test->dealJacketGroup->uuid],
        'dealer.audit.deal-jackets.destroy' => [
            'dealJacketGroup' => $test->dealJacketGroup->uuid,
            'dealJacket' => $test->dealJacket->uuid,
        ],
        'dealer.audit.deal-jackets.destroy-group' => ['dealJacketGroup' => $test->dealJacketGroup->uuid],
        'dealer.audit.deal-jackets.edit' => [
            'dealJacketGroup' => $test->dealJacketGroup->uuid,
            'dealJacket' => $test->dealJacket->uuid,
        ],
        'dealer.audit.deal-jackets.show' => ['dealJacketGroup' => $test->dealJacketGroup->uuid],
        'dealer.audit.deal-jackets.store' => ['dealJacketGroup' => $test->dealJacketGroup->uuid],
        'dealer.audit.deal-jackets.update' => [
            'dealJacketGroup' => $test->dealJacketGroup->uuid,
            'dealJacket' => $test->dealJacket->uuid,
        ],

        'dealer.audit.individual.create' => ['individualAudit' => $test->individualAudit->id],
        'dealer.audit.individual.create-child' => ['individualAudit' => $test->individualAudit->uuid],
        'dealer.audit.individual.destroy' => ['individualAudit' => $test->individualAudit->uuid],
        'dealer.audit.individual.download' => ['individualAudit' => $test->individualAudit->uuid],
        'dealer.audit.individual.edit' => ['individualAudit' => $test->individualAudit->uuid],
        'dealer.audit.individual.generate' => ['individualAudit' => $test->individualAudit->uuid],
        'dealer.audit.individual.show' => ['individualAudit' => $test->individualAudit->uuid],
        'dealer.audit.individual.update' => ['individualAudit' => $test->individualAudit->uuid],

        'dealer.courses.edit' => ['course' => coverageCourse($test)->slug],
        'dealer.courses.quiz' => ['course' => coverageCourse($test)->slug],
        'dealer.courses.results.store' => ['course' => coverageCourse($test)->slug],
        'dealer.courses.show' => ['course' => coverageCourse($test)->slug],
        'dealer.courses.video-complete' => ['course' => coverageCourse($test)->slug],

        'dealer.dashboard.audit-type-report' => ['type' => 'osha'],

        'dealer.dealer.settings.general.update' => ['store' => $test->store->id],
        'dealer.dealer.settings.managers.update' => ['store' => $test->store->id],
        'dealer.dealer.settings.compliance.update' => ['store' => $test->store->id],
        'dealer.dealer.settings.compliance.download' => ['store' => $test->store->id],
        'dealer.dealer.settings.reset-courses.run' => ['store' => $test->store->id],

        'dealer.doc.destroy' => ['dealerDoc' => $test->dealerDoc->id],
        'dealer.doc.download' => ['dealerDoc' => $test->dealerDoc->id],
        'dealer.doc.shared.download' => ['sharedDocument' => $test->sharedDocument->id],

        'dealer.employees.course-overrides.update' => [
            'user' => $test->employee->slug,
            'course' => coverageCourse($test)->id,
        ],
        'dealer.employees.courses.record-result' => [
            'user' => $test->employee->slug,
            'course' => coverageCourse($test)->id,
        ],
        'dealer.employees.deleted.restore' => ['user' => $test->deletedEmployee->id],
        'dealer.employees.destroy' => ['user' => $test->employee->slug],
        'dealer.employees.dot-certificates.generate' => ['user' => $test->employee->slug],
        'dealer.employees.impersonate' => ['user' => $test->employee->slug],
        'dealer.employees.open-invites.destroy' => ['invite' => Invite::query()->create([
            'name' => 'Invite Open Resend',
            'email' => 'invite-open-destroy-'.Str::random(6).'@test-tenant.localhost',
            'stores' => [$test->store->id],
            'department_id' => $test->department->id,
            'user_id' => $test->routeConsultant->id,
            'roles' => ['Employee'],
            'invitation_token' => Str::random(32),
            'courses' => [],
        ])->id],
        'dealer.employees.open-invites.resend-one' => ['invite' => Invite::query()->create([
            'name' => 'Invite Open Resend One',
            'email' => 'invite-open-resend-'.Str::random(6).'@test-tenant.localhost',
            'stores' => [$test->store->id],
            'department_id' => $test->department->id,
            'user_id' => $test->routeConsultant->id,
            'roles' => ['Employee'],
            'invitation_token' => Str::random(32),
            'courses' => [],
        ])->id],
        'dealer.employees.show.courses' => ['user' => $test->employee->slug],
        'dealer.employees.show.dot-certificates' => ['user' => $test->employee->slug],
        'dealer.employees.update' => ['user' => $test->employee->slug],

        'dealer.fit-tests.destroy' => ['fitTestDoc' => $test->fitTestDoc->id],
        'dealer.fit-tests.download' => ['fitTestDoc' => $test->fitTestDoc->id],

        'dealer.locations.update' => ['store' => $test->store->id],

        'dealer.manual.cms.destroy' => ['manual' => $test->cmsManual->id],
        'dealer.manual.cms.download' => ['manual' => $test->cmsManual->id],
        'dealer.manual.isp.destroy' => ['manual' => $test->ispManual->id],
        'dealer.manual.isp.download' => ['manual' => $test->ispManual->id],
        'dealer.manual.osha.destroy' => ['manual' => $test->oshaManual->id],
        'dealer.manual.osha.download' => ['manual' => $test->oshaManual->id],
        'dealer.manual.red-flag.destroy' => ['manual' => $test->redFlagManual->id],
        'dealer.manual.red-flag.download' => ['manual' => $test->redFlagManual->id],

        'dealer.notifications.destroy' => ['notification' => $notification->id],
        'dealer.notifications.mark-read' => ['notification' => $notification->id],

        'dealer.scan.report-status' => ['type' => 'executive'],

        'dealer.settings.global.courses.optional' => ['course' => coverageCourse($test)->id],
        'dealer.settings.global.stores.notifications' => ['store' => $test->store->id],
        'dealer.settings.global.stores.remediations' => ['store' => $test->store->id],

        'dealer.vendor.destroy' => ['vendor' => $test->vendor->id],
        'dealer.vendor.forms.download' => ['vendorForm' => $test->vendorForm->id],
        'dealer.vendor.forms.send' => ['vendor' => $test->vendor->id],
        'dealer.vendor.show' => ['vendor' => $test->vendor->id],

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

function refreshAuditFixtures(object $test): void
{
    $oshaMissing = OshaViolationAudit::query()->whereKey($test->oshaAudit->id)->doesntExist();
    if ($oshaMissing) {
        $test->oshaAudit = OshaViolationAudit::query()->create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $test->routeConsultant->id,
            'store_id' => $test->store->id,
            'date' => now()->toDateString(),
        ]);
    }

    $bodyShopMissing = BodyShopViolationAudit::query()->whereKey($test->bodyShopAudit->id)->doesntExist();
    if ($bodyShopMissing) {
        $test->bodyShopAudit = BodyShopViolationAudit::query()->create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $test->routeConsultant->id,
            'store_id' => $test->store->id,
            'date' => now()->toDateString(),
        ]);
    }

    $glbaMissing = GlbaViolationAudit::query()->whereKey($test->glbaAudit->id)->doesntExist();
    if ($glbaMissing) {
        $test->glbaAudit = GlbaViolationAudit::query()->create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $test->routeConsultant->id,
            'store_id' => $test->store->id,
            'date' => now()->toDateString(),
        ]);
    }

    foreach (
        [
            'osha' => [$test->oshaAudit, OshaViolationAudit::class, 'oshaComment', 'oshaViolation'],
            'body-shop' => [$test->bodyShopAudit, BodyShopViolationAudit::class, 'bodyShopComment', 'bodyShopViolation'],
            'finance' => [$test->glbaAudit, GlbaViolationAudit::class, 'glbaComment', 'glbaViolation'],
        ] as $entry
    ) {
        [$audit, $modelClass, $commentField, $violationField] = $entry;

        $commentBelongsToCurrentAudit = (int) $test->{$commentField}->auditable_id === (int) $audit->id;
        if (AuditComment::query()->whereKey($test->{$commentField}->id)->doesntExist() || ! $commentBelongsToCurrentAudit) {
            $test->{$commentField} = AuditComment::query()->create([
                'user_id' => $test->routeConsultant->id,
                'auditable_id' => $audit->id,
                'auditable_type' => $modelClass,
                'comment' => 'Route coverage refreshed comment.',
            ]);
        }

        $violationBelongsToCurrentAudit = (int) $test->{$violationField}->violationable_id === (int) $audit->id;
        if (! $violationBelongsToCurrentAudit
            || App\Models\Dealer\Violation::query()->whereKey($test->{$violationField}->id)->doesntExist()
        ) {
            $test->{$violationField} = $audit->violations()->create([
                'uuid' => (string) Str::uuid(),
                'statement_id' => 0,
                'statement' => 'Route coverage refreshed violation.',
                'risk' => false,
            ]);
        }
    }
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

    $allowedNotFound = [
        'dealer.scan.report',
        // These dashboard PDF endpoints legitimately 404 when no completed,
        // graded audits exist in scope, which the smoke fixtures do not seed.
        'dealer.dashboard.audit-report',
        'dealer.dashboard.audit-type-report',
    ];

    if (! in_array($routeName, $allowedNotFound, true)) {
        expect($status)
            ->not->toBe(404, "{$routeName} returned 404.");
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
        refreshAuditFixtures($this);
        $name = (string) $route->getName();

        $method = firstHttpMethod($route);
        $actor = actorForNamedRoute($this, $route, consultantMode: false);

        if (routeHasMiddleware($route, 'role:super-admin') && ! $actor instanceof User) {
            continue;
        }

        $params = namedRouteParameters($this, $name, $actor);
        $payload = namedRoutePayload($this, $name);

        $url = routeHasMiddleware($route, 'signed')
            ? URL::signedRoute($name, array_merge($params, match ($name) {
                'dealer.dealer.settings.form', 'dealer.dealer.settings.form.update' => ['store' => $this->store->id],
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
        refreshAuditFixtures($this);
        $name = (string) $route->getName();

        if (routeHasExactMiddleware($route, 'role:super-admin')) {
            continue;
        }

        $method = firstHttpMethod($route);
        $actor = actorForNamedRoute($this, $route, consultantMode: true);
        $params = namedRouteParameters($this, $name, $actor);
        $payload = namedRoutePayload($this, $name);

        $url = routeHasMiddleware($route, 'signed')
            ? URL::signedRoute($name, array_merge($params, match ($name) {
                'dealer.dealer.settings.form', 'dealer.dealer.settings.form.update' => ['store' => $this->store->id],
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
    // Each entry is [method, route, params]. individual.create is POST (GET on
    // the same URI matches individual.index, which managers can read).
    $restrictedRoutes = [
        ['get', 'dealer.settings.global', []],
        ['get', 'dealer.settings.global.reset-courses', []],
        ['get', 'dealer.audit.osha.create', ['store' => $this->store->id]],
        ['get', 'dealer.audit.body-shop.create', ['store' => $this->store->id]],
        ['get', 'dealer.audit.finance.create', ['store' => $this->store->id]],
        ['post', 'dealer.audit.individual.create', []],
    ];

    foreach ($restrictedRoutes as [$method, $routeName, $params]) {
        $this->actingAs($this->manager)
            ->{$method}(route($routeName, $params))
            ->assertForbidden();

        $this->actingAs($this->employee)
            ->{$method}(route($routeName, $params))
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
