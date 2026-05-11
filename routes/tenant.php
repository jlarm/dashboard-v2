<?php

declare(strict_types=1);

use App\Enums\ViolationAuditType;
use App\Http\Controllers\Dealer\Audit\IndividualController;
use App\Http\Controllers\Dealer\Audit\IndividualCreateController;
use App\Http\Controllers\Dealer\Audit\IndividualIndexController;
use App\Http\Controllers\Dealer\Audit\SingleIndividualController;
use App\Http\Controllers\Dealer\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Dealer\CourseController;
use App\Http\Controllers\Dealer\CourseResultsController;
use App\Http\Controllers\Dealer\ImpersonationController;
use App\Http\Controllers\Dealer\Store\CreateFirstStoreController;
use App\Http\Controllers\Dealer\StoreController;
use App\Http\Controllers\Dealer\UserController;
use App\Http\Controllers\Dealer\VendorController;
use App\Http\Controllers\Tenant\Audit\DealJacketController;
use App\Http\Controllers\Tenant\Audit\DealJacketGroupController;
use App\Http\Controllers\Tenant\Audit\DealJacketReportDownloadController;
use App\Http\Controllers\Tenant\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Tenant\Auth\NewPasswordController;
use App\Http\Controllers\Tenant\Auth\PasswordResetLinkController;
use App\Http\Controllers\Tenant\CyrismaController;
use App\Http\Controllers\Tenant\CyrismaReportController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\DealerDocController;
use App\Http\Controllers\Tenant\LogController;
use App\Http\Controllers\Tenant\Manuals\CmsController;
use App\Http\Controllers\Tenant\Manuals\IspController;
use App\Http\Controllers\Tenant\Manuals\OshaController;
use App\Http\Controllers\Tenant\Manuals\RedFlagController;
use App\Http\Controllers\Tenant\NotificationsController;
use App\Http\Controllers\Tenant\ScanArchiveController;
use App\Http\Controllers\Tenant\ScansController;
use App\Http\Controllers\Tenant\SdsController;
use App\Http\Controllers\Tenant\Settings\AutomatedReportsController;
use App\Http\Controllers\Tenant\Settings\GlobalSettingsController;
use App\Http\Controllers\Tenant\Settings\PasswordController as SettingsPasswordController;
use App\Http\Controllers\Tenant\Settings\ProfileController as SettingsProfileController;
use App\Http\Controllers\Tenant\Settings\StoreSettingsController;
use App\Http\Controllers\Tenant\Store\LocationController;
use App\Http\Controllers\Tenant\Store\SwitchStoreController;
use App\Http\Controllers\Tenant\UserController as TenantUserController;
use App\Http\Controllers\WebhookController;
use App\Http\Livewire\Dealer\Phish\Create;
use App\Http\Livewire\Dealer\Phish\Show;
use App\Http\Livewire\Dealer\Ridgeback\Index;
use App\Http\Livewire\Dealer\Settings\FrontEndComplianceForm;
use App\Routing\ViolationAuditRoutes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Features\UserImpersonation;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::name('dealer.')->middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
    'tenant.not-suspended',
    'tenant.requires-store',
])->group(function (): void {

    // **************************************************
    // All Access
    // **************************************************

    Route::inertia('/', 'tenant/Welcome')->name('welcome');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');

    Route::get('/dashboard', [DashboardController::class, 'show'])->middleware('auth')->name('dashboard');
    Route::get('/dashboard/audit-report', [DashboardController::class, 'downloadAuditReport'])->middleware('auth')->name('dashboard.audit-report');
    Route::get('/dashboard/audit-report/{type}', [DashboardController::class, 'downloadAuditTypeReport'])
        ->whereIn('type', ['osha', 'body_shop', 'glba', 'deal_jacket'])
        ->middleware('auth')
        ->name('dashboard.audit-type-report');
    Route::post('/dashboard/first-store', CreateFirstStoreController::class)->middleware('auth')->name('store.first');
    Route::post('/current-store', SwitchStoreController::class)->middleware('auth')->name('store.switch');

    Route::redirect('stores/{path?}', '/dashboard')
        ->where('path', '.*')
        ->name('legacy-stores.redirect');

    Route::get('invite_registration/{invite:invitation_token}', [UserController::class, 'create'])
        ->missing(fn () => response()->view('errors.link-expired'))
        ->middleware('web')->name('employees.create');
    Route::post('employees/dealer/store', [UserController::class, 'store'])->name('employees.store');

    Route::middleware('auth')->prefix('sds-sheets')->name('sds.')->group(function (): void {
        Route::get('/', [SdsController::class, 'index'])->name('index');
        Route::post('request', [SdsController::class, 'storeRequest'])->name('request');
        Route::get('{uuid}/view', [SdsController::class, 'view'])->name('view');
    });

    Route::prefix('courses/')->name('courses.')->group(function (): void {
        Route::view('/', 'dealer.course.index')->middleware('auth')->name('index');
        Route::view('all', 'dealer.course.all')->middleware(['auth', 'role:super-admin|Consultant'])->name('all');
        Route::get('{course:slug}', [CourseController::class, 'show'])->middleware('auth')->name('show');
        Route::post('{course:slug}', [CourseResultsController::class, 'store'])->middleware('auth')->name('results.store');
        //        Route::get('{course:slug}/edit', [CourseController::class, 'edit'])->middleware('auth')->name('edit');
        Route::get('{course:slug}/quiz', [CourseController::class, 'quiz'])->middleware('auth')->name('quiz');
    });

    Route::get('form', [VendorController::class, 'form'])->middleware('signed')->name('vendor.form');
    Route::post('form', [VendorController::class, 'submit'])->middleware('signed')->name('vendor.submit');
    Route::get('/vendors/thankyou', [VendorController::class, 'thankyou'])->name('vendors.thankyou');

    Route::middleware('auth')->prefix('vendors')->name('vendor.')->group(function (): void {
        Route::get('/', [VendorController::class, 'index'])->name('index');
        Route::post('/', [VendorController::class, 'store'])->name('store');
        Route::get('forms/{vendorForm}/download', [VendorController::class, 'downloadForm'])->name('forms.download');
        Route::get('{vendor}', [VendorController::class, 'show'])->name('show');
        Route::post('{vendor}/forms', [VendorController::class, 'sendForm'])->name('forms.send');
        Route::delete('{vendor}', [VendorController::class, 'destroy'])->name('destroy');
    });

    Route::get('email/settings', FrontEndComplianceForm::class)->name('dealer.settings.form')->middleware('signed');

    Route::middleware('auth')->group(function (): void {
        Route::get('/profile', [SettingsProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [SettingsProfileController::class, 'update'])->name('profile.update');

        Route::get('/password', [SettingsPasswordController::class, 'edit'])->name('user-password.edit');
        Route::put('/password', [SettingsPasswordController::class, 'update'])
            ->middleware('throttle:6,1')
            ->name('password.update');

        Route::inertia('/appearance', 'tenant/settings/Appearance')->name('appearance.edit');

        Route::prefix('notifications')->name('notifications.')->group(function (): void {
            Route::post('mark-all-read', [NotificationsController::class, 'markAllAsRead'])->name('mark-all-read');
            Route::post('{notification}/read', [NotificationsController::class, 'markAsRead'])->name('mark-read');
            Route::delete('{notification}', [NotificationsController::class, 'destroy'])->name('destroy');
        });
    });

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->middleware('auth')->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store'])->middleware('auth');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

    // **************************************************
    // Roles to Super Admin
    // **************************************************

    Route::middleware('role:super-admin|Consultant')->group(function (): void {
        Route::get('global-settings', [GlobalSettingsController::class, 'index'])->name('settings.global');

        Route::prefix('global-settings')->name('settings.global.')->group(function (): void {
            Route::get('course-management', [GlobalSettingsController::class, 'index'])
                ->defaults('section', 'course-management')
                ->name('course-management');
            Route::get('reset-courses', [GlobalSettingsController::class, 'index'])
                ->defaults('section', 'reset-courses')
                ->name('reset-courses');
            Route::get('phishing', [GlobalSettingsController::class, 'index'])
                ->defaults('section', 'phishing')
                ->name('phishing');

            Route::patch('phishing', [GlobalSettingsController::class, 'updatePhishing'])->name('phishing.update');
            Route::post('stores/{store}/notifications', [GlobalSettingsController::class, 'toggleStoreNotifications'])->name('stores.notifications');
            Route::post('stores/{store}/remediations', [GlobalSettingsController::class, 'toggleStoreRemediations'])->name('stores.remediations');
            Route::patch('courses/{course}/optional', [GlobalSettingsController::class, 'toggleOptionalCourse'])->name('courses.optional');
            Route::post('reset-courses', [GlobalSettingsController::class, 'resetCourses'])->name('reset-courses.run');
        });
    });

    Route::middleware('role:super-admin|Admin|Consultant|Owner|GM|CFO|GSM|Qualified Individual')
        ->prefix('automated-reports')
        ->name('settings.automated-reports.')
        ->group(function (): void {
            Route::get('/', [AutomatedReportsController::class, 'index'])->name('index');
            Route::patch('/', [AutomatedReportsController::class, 'update'])->name('update');
            Route::post('send', [AutomatedReportsController::class, 'sendNow'])->name('send');
        });

    // **************************************************
    // Roles to Consultant
    // **************************************************

    Route::middleware('role:super-admin|Consultant')->group(function (): void {

        Route::prefix('audits/')->name('audit.')->middleware(['auth', 'single.store'])->group(function (): void {
            ViolationAuditRoutes::registerWrites('osha', 'osha', ViolationAuditType::Osha);
            ViolationAuditRoutes::registerWrites('body-shop', 'body-shop', ViolationAuditType::BodyShop);
            ViolationAuditRoutes::registerWrites('finance', 'finance', ViolationAuditType::Glba);
            Route::get('deal-jackets-archived/create/{individualAudit:id?}', IndividualCreateController::class)->name('individual.create');
            Route::get('deal-jackets-archived/{individualAudit:uuid}', IndividualController::class)->name('individual.show');
            Route::get('deal-jackets-archived/{individualAudit:uuid}/edit', SingleIndividualController::class)->name('individual.edit');

            Route::get('deal-jackets/{dealJacketGroup:uuid}/create', [DealJacketController::class, 'create'])->name('deal-jackets.create');
            Route::get('deal-jackets/{dealJacketGroup:uuid}/edit/{dealJacket:uuid}', [DealJacketController::class, 'edit'])->name('deal-jackets.edit');
        });

        Route::get('phishing/create', Create::class)->name('phishing.create');

        Route::get('ridgeback', Index::class)
            ->middleware(['auth', 'single.store'])
            ->name('ridgeback.index');

        Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
        Route::post('locations', [LocationController::class, 'store'])->name('locations.store');
        Route::patch('locations/{store}', [LocationController::class, 'update'])->name('locations.update');

    });

    Route::middleware(['auth', 'role:super-admin|Consultant'])->prefix('logs')->name('logs.')->group(function (): void {
        Route::get('/', [LogController::class, 'index'])->name('index');
        Route::get('{activity:id}', [LogController::class, 'show'])->name('show');
    });

    // **************************************************
    // Roles to QA
    // **************************************************

    Route::middleware('role:super-admin|Consultant|Owner|CFO|GM|GSM|Qualified Individual')->group(function (): void {

        Route::get('employees/deleted', [TenantUserController::class, 'deleted'])->name('employees.deleted');
        Route::post('employees/deleted/{user}/restore', [TenantUserController::class, 'restoreEmployee'])
            ->name('employees.deleted.restore')
            ->withTrashed();

        Route::get('settings', [StoreSettingsController::class, 'index'])
            ->defaults('section', 'general')
            ->middleware(['auth'])
            ->name('dealer.settings');
        Route::prefix('settings')->middleware(['auth'])->name('dealer.settings.')->group(function (): void {
            Route::patch('general/{store}', [StoreSettingsController::class, 'updateGeneral'])->name('general.update');
            Route::patch('managers/{store}', [StoreSettingsController::class, 'updateManagers'])->name('managers.update');
            Route::patch('compliance/{store}', [StoreSettingsController::class, 'updateCompliance'])->name('compliance.update');
            Route::get('compliance/{store}/download', [StoreSettingsController::class, 'downloadCompliance'])->name('compliance.download');
            Route::get('managers', [StoreSettingsController::class, 'index'])
                ->defaults('section', 'managers')
                ->name('managers');
            Route::get('compliance', [StoreSettingsController::class, 'index'])
                ->defaults('section', 'compliance')
                ->name('compliance');
            Route::get('reset-courses', [StoreSettingsController::class, 'index'])
                ->defaults('section', 'reset-courses')
                ->middleware('can:create-dealerships')
                ->name('reset-courses');
            Route::post('reset-courses/{store}', [StoreSettingsController::class, 'resetCourses'])
                ->middleware('can:create-dealerships')
                ->name('reset-courses.run');
        });
        Route::get('edit', [StoreController::class, 'edit'])->middleware(['auth'])->name('store.edit');

        Route::get('phishing', App\Http\Livewire\Dealer\Phish\Index::class)->name('phishing.index');
        Route::get('phishing/{phishingCampaign}', Show::class)->name('phishing.show');
    });

    // **************************************************
    // Manuals — every role except Manager, Employee, Porter/Driver
    // **************************************************

    Route::middleware([
        'auth',
        'single.store',
        'role:super-admin|Admin|Consultant|Owner|CFO|GM|GSM|Qualified Individual',
    ])
        ->prefix('manuals/')
        ->name('manual.')
        ->group(function (): void {
            Route::get('isp', [IspController::class, 'index'])->name('isp.index');
            Route::get('isp/create', [IspController::class, 'create'])->name('isp.create');
            Route::post('isp', [IspController::class, 'store'])->name('isp.store');
            Route::delete('isp/{manual}', [IspController::class, 'destroy'])->name('isp.destroy');

            Route::get('osha', [OshaController::class, 'index'])->name('osha.index');
            Route::get('osha/create', [OshaController::class, 'create'])->name('osha.create');
            Route::post('osha', [OshaController::class, 'store'])->name('osha.store');
            Route::delete('osha/{manual}', [OshaController::class, 'destroy'])->name('osha.destroy');

            Route::get('red-flag', [RedFlagController::class, 'index'])->name('red-flag.index');
            Route::get('red-flag/create', [RedFlagController::class, 'create'])->name('red-flag.create');
            Route::post('red-flag', [RedFlagController::class, 'store'])->name('red-flag.store');
            Route::delete('red-flag/{manual}', [RedFlagController::class, 'destroy'])->name('red-flag.destroy');

            Route::get('cms', [CmsController::class, 'index'])->name('cms.index');
            Route::get('cms/create', [CmsController::class, 'create'])->name('cms.create');
            Route::post('cms', [CmsController::class, 'store'])->name('cms.store');
            Route::delete('cms/{manual}', [CmsController::class, 'destroy'])->name('cms.destroy');
        });

    // **************************************************
    // Roles to Manager
    // **************************************************

    Route::middleware('role:super-admin|Consultant|Owner|CFO|GM|GSM|Qualified Individual|Manager')->group(function (): void {

        Route::prefix('employees')->name('employees.')->group(function (): void {
            Route::get('/', [TenantUserController::class, 'index'])->name('index');
            Route::get('/invite', [TenantUserController::class, 'invite'])->name('invite');
            Route::post('/invite', [TenantUserController::class, 'storeInvite'])->name('invite.store');
            Route::get('/open-invites', [TenantUserController::class, 'openInvites'])->name('open-invites');
            Route::post('/open-invites/resend', [TenantUserController::class, 'resendInvites'])->name('open-invites.resend');
            Route::post('/open-invites/{invite}/resend', [TenantUserController::class, 'resendInvite'])->name('open-invites.resend-one');
            Route::delete('/open-invites/{invite}', [TenantUserController::class, 'destroyInvite'])->name('open-invites.destroy');
            Route::post('/import', [TenantUserController::class, 'import'])->name('import');
            Route::post('/export', [TenantUserController::class, 'export'])->name('export');
            Route::post('/email-report', [TenantUserController::class, 'emailReport'])->name('email-report');
            Route::post('/send-message', [TenantUserController::class, 'sendMessage'])->name('send-message');

            Route::prefix('{user:slug}')->group(function (): void {
                Route::get('/', [TenantUserController::class, 'show'])->name('show');
                Route::get('courses', [TenantUserController::class, 'courses'])->name('show.courses');
                Route::post('courses/{course}/result', [TenantUserController::class, 'recordCourseResult'])->name('courses.record-result');
                Route::get('manage-courses', [TenantUserController::class, 'manageCourses'])
                    ->middleware('role:super-admin|Consultant|Qualified Individual')
                    ->name('show.manage-courses');
                Route::patch('course-overrides/{course}', [TenantUserController::class, 'updateCourseOverride'])
                    ->middleware('role:super-admin|Consultant|Qualified Individual')
                    ->name('course-overrides.update');
                Route::get('dot-certificates', [TenantUserController::class, 'dotCertificates'])->name('show.dot-certificates');
                Route::post('dot-certificates', [TenantUserController::class, 'generateDotCertificate'])->name('dot-certificates.generate');
                Route::patch('/', [TenantUserController::class, 'update'])->name('update');
                Route::delete('/', [TenantUserController::class, 'destroy'])->name('destroy');
                Route::post('impersonate', [TenantUserController::class, 'impersonate'])->name('impersonate');
            });
        });

        Route::get('scans', [ScansController::class, 'index'])->middleware(['single.store'])->name('scan.index');
        Route::get('scans/external-finding', [ScansController::class, 'externalFinding'])->middleware(['single.store'])->name('scan.external-finding');
        Route::post('scans/queue-report', [ScansController::class, 'queueReport'])->middleware(['single.store'])->name('scan.queue-report');
        Route::post('scans/refresh-cache', [ScansController::class, 'refreshCache'])->middleware(['single.store'])->name('scan.refresh-cache');

        Route::middleware(['single.store', 'role:super-admin|Consultant'])->group(function (): void {
            Route::get('scans/settings', [CyrismaController::class, 'settings'])->name('scan.settings');
            Route::put('scans/settings', [CyrismaController::class, 'update'])->name('scan.settings.update');
        });

        Route::middleware(['single.store'])->group(function (): void {
            Route::get('scans/report/{type}', [CyrismaReportController::class, 'download'])->name('scan.report');
        });

        Route::middleware(['auth', 'single.store'])->group(function (): void {
            Route::get('scans-archive', [ScanArchiveController::class, 'index'])->name('scan.archive');
            Route::post('scans-archive/upload', [ScanArchiveController::class, 'upload'])->name('scan.archive.upload');
        });

        Route::prefix('audits/')->name('audit.')->middleware(['auth', 'single.store'])->group(function (): void {
            ViolationAuditRoutes::registerReads('osha', 'osha', ViolationAuditType::Osha);
            ViolationAuditRoutes::registerReads('body-shop', 'body-shop', ViolationAuditType::BodyShop);
            ViolationAuditRoutes::registerReads('finance', 'finance', ViolationAuditType::Glba);
            Route::get('deal-jackets-archived', IndividualIndexController::class)->name('individual.index');
            Route::view('deal-jackets', 'tenant.audit.deal-jacket.index')->middleware(['auth', 'single.store'])->name('deal-jackets.index');
            Route::get('deal-jackets/{dealJacketGroup:uuid}', [DealJacketGroupController::class, 'show'])->middleware(['auth', 'single.store'])->name('deal-jackets.show');
            Route::get('deal-jackets/{dealJacketGroup:uuid}/{dealJacket:uuid}', [DealJacketController::class, 'show'])->name('deal-jackets.single');
            Route::get('deal-jacket-reports/{fileName}/download', [DealJacketReportDownloadController::class, 'download'])->name('deal-jacket-reports.download');
        });

        Route::prefix('documents')->name('doc.')->middleware('auth')->group(function (): void {
            Route::get('/', [DealerDocController::class, 'index'])->name('index');
            Route::post('/', [DealerDocController::class, 'store'])->name('store');
            Route::get('{dealerDoc}/download', [DealerDocController::class, 'download'])->name('download');
            Route::get('shared/{sharedDocument}/download', [DealerDocController::class, 'downloadShared'])->whereNumber('sharedDocument')->name('shared.download');
            Route::delete('{dealerDoc}', [DealerDocController::class, 'destroy'])->name('destroy');
        });

        Route::get('fit-tests', App\Http\Livewire\Tenant\Audit\Fit\Index::class)->name('fit-tests.index');

    });

    // Impersonation routes
    Route::get('/impersonate/{token}', fn ($token): RedirectResponse => UserImpersonation::makeResponse($token))->name('impersonate.token');

    Route::get('/employee/{user}/impersonate', [ImpersonationController::class, 'impersonate'])
        ->name('employee.impersonate')
        ->middleware('auth');

    Route::get('/stop-impersonation', [ImpersonationController::class, 'stopImpersonation'])
        ->name('stop.impersonation')
        ->middleware('auth');

});

Route::middleware([
    'api',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function (): void {
    Route::post('/webhooks/gophish/', [WebhookController::class, 'gophish'])->name('webhooks.gophish');
});
