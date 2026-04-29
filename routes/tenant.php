<?php

declare(strict_types=1);

use App\Http\Controllers\Dealer\Audit\BodyShopCreateController;
use App\Http\Controllers\Dealer\Audit\FinanceCreateController;
use App\Http\Controllers\Dealer\Audit\IndividualController;
use App\Http\Controllers\Dealer\Audit\IndividualCreateController;
use App\Http\Controllers\Dealer\Audit\IndividualIndexController;
use App\Http\Controllers\Dealer\Audit\OshaCreateController;
use App\Http\Controllers\Dealer\Audit\SingleIndividualController;
use App\Http\Controllers\Dealer\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Dealer\CourseController;
use App\Http\Controllers\Dealer\CourseResultsController;
use App\Http\Controllers\Dealer\ImpersonationController;
use App\Http\Controllers\Dealer\Store\CreateFirstStoreController;
use App\Http\Controllers\Dealer\Store\SettingsController;
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
use App\Http\Controllers\Tenant\DealerDocController;
use App\Http\Controllers\Tenant\LogController;
use App\Http\Controllers\Tenant\NotificationsController;
use App\Http\Controllers\Tenant\SdsController;
use App\Http\Controllers\Tenant\Settings\AutomatedReportsController;
use App\Http\Controllers\Tenant\Settings\GlobalSettingsController;
use App\Http\Controllers\Tenant\Settings\PasswordController as SettingsPasswordController;
use App\Http\Controllers\Tenant\Settings\ProfileController as SettingsProfileController;
use App\Http\Controllers\Tenant\Store\LocationController;
use App\Http\Controllers\Tenant\Store\SwitchStoreController;
use App\Http\Controllers\WebhookController;
use App\Http\Livewire\Dealer\Audit\Osha\Edit;
use App\Http\Livewire\Dealer\Audit\Osha\RemediationForm;
use App\Http\Livewire\Dealer\Audit\Osha\Single;
use App\Http\Livewire\Dealer\Phish\Create;
use App\Http\Livewire\Dealer\Ridgeback\Index;
use App\Http\Livewire\Dealer\Settings\FrontEndComplianceForm;
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

    Route::inertia('/dashboard', 'tenant/Dashboard')->middleware('auth')->name('dashboard');
    Route::post('/dashboard/first-store', CreateFirstStoreController::class)->middleware('auth')->name('store.first');
    Route::post('/current-store', SwitchStoreController::class)->middleware('auth')->name('store.switch');

    Route::any('stores/{path?}', static fn () => to_route('dealer.dashboard'))
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
            Route::get('osha/create/{store}', OshaCreateController::class)->name('osha.create');
            Route::get('osha/{oshaViolationAudit:uuid}/edit', Edit::class)->name('osha.edit');
            Route::get('body-shop/create/{store}', BodyShopCreateController::class)->name('body-shop.create');
            Route::get('body-shop/{bodyShopViolationAudit:uuid}/edit', App\Http\Livewire\Dealer\Audit\BodyShop\Edit::class)->name('body-shop.edit');
            Route::get('finance/create/{store}', FinanceCreateController::class)->middleware('can:create-audits')->name('finance.create');
            Route::get('finance/{glbaViolationAudit:uuid}/edit', App\Http\Livewire\Dealer\Audit\Finance\Edit::class)->name('finance.edit');
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

        Route::get('employees/deleted', [App\Http\Controllers\Tenant\UserController::class, 'deleted'])->name('employees.deleted');
        Route::post('employees/deleted/{user}/restore', [App\Http\Controllers\Tenant\UserController::class, 'restoreEmployee'])
            ->name('employees.deleted.restore')
            ->withTrashed();

        Route::prefix('manuals/')->name('manual.')->middleware(['auth', 'single.store'])->group(function (): void {
            Route::get('/isp', App\Http\Livewire\Dealer\Manual\Isp\Index::class)->name('isp.index');
            Route::get('/isp/create', App\Http\Livewire\Dealer\Manual\Isp\Create::class)->middleware(['single.store'])->name('isp.create');
            Route::get('/osha', App\Http\Livewire\Dealer\Manual\Osha\Index::class)->name('osha.index');
            Route::get('/osha/create', App\Http\Livewire\Dealer\Manual\Osha\Create::class)->middleware(['single.store'])->name('osha.create');
            Route::get('/red-flag', App\Http\Livewire\Dealer\Manual\RedFlag\Index::class)->name('red-flag.index');
            Route::get('/red-flag/create', App\Http\Livewire\Dealer\Manual\RedFlag\Create::class)->middleware(['single.store'])->name('red-flag.create');
            Route::get('cms', App\Http\Livewire\Dealer\Manual\Cms\Index::class)->name('cms.index');
            Route::get('cms/create', App\Http\Livewire\Dealer\Manual\Cms\Create::class)->middleware(['single.store'])->name('cms.create');
        });

        Route::get('settings', SettingsController::class)->middleware(['auth'])->name('dealer.settings');
        Route::prefix('settings')->middleware(['auth'])->name('dealer.settings.')->group(function (): void {
            Route::get('managers', [SettingsController::class, 'show'])
                ->defaults('section', 'managers')
                ->name('managers');
            Route::get('compliance', [SettingsController::class, 'show'])
                ->defaults('section', 'compliance')
                ->name('compliance');
            Route::get('reset-courses', [SettingsController::class, 'show'])
                ->defaults('section', 'reset-courses')
                ->middleware('can:create-dealerships')
                ->name('reset-courses');
            Route::get('ridgeback', [SettingsController::class, 'show'])
                ->defaults('section', 'ridgeback')
                ->middleware('can:create-dealerships')
                ->name('ridgeback');
        });
        Route::get('edit', [StoreController::class, 'edit'])->middleware(['auth'])->name('store.edit');

        Route::get('phishing', App\Http\Livewire\Dealer\Phish\Index::class)->name('phishing.index');
        Route::get('phishing/{phishingCampaign}', App\Http\Livewire\Dealer\Phish\Show::class)->name('phishing.show');
    });

    // **************************************************
    // Roles to Manager
    // **************************************************

    Route::middleware('role:super-admin|Consultant|Owner|CFO|GM|GSM|Qualified Individual|Manager')->group(function (): void {

        Route::prefix('employees')->name('employees.')->group(function (): void {
            Route::get('/', [App\Http\Controllers\Tenant\UserController::class, 'index'])->name('index');
            Route::get('/invite', [App\Http\Controllers\Tenant\UserController::class, 'invite'])->name('invite');
            Route::post('/invite', [App\Http\Controllers\Tenant\UserController::class, 'storeInvite'])->name('invite.store');
            Route::get('/open-invites', [App\Http\Controllers\Tenant\UserController::class, 'openInvites'])->name('open-invites');
            Route::post('/open-invites/resend', [App\Http\Controllers\Tenant\UserController::class, 'resendInvites'])->name('open-invites.resend');
            Route::post('/open-invites/{invite}/resend', [App\Http\Controllers\Tenant\UserController::class, 'resendInvite'])->name('open-invites.resend-one');
            Route::delete('/open-invites/{invite}', [App\Http\Controllers\Tenant\UserController::class, 'destroyInvite'])->name('open-invites.destroy');
            Route::post('/import', [App\Http\Controllers\Tenant\UserController::class, 'import'])->name('import');
            Route::post('/export', [App\Http\Controllers\Tenant\UserController::class, 'export'])->name('export');
            Route::post('/email-report', [App\Http\Controllers\Tenant\UserController::class, 'emailReport'])->name('email-report');
            Route::post('/send-message', [App\Http\Controllers\Tenant\UserController::class, 'sendMessage'])->name('send-message');

            Route::prefix('{user:slug}')->group(function (): void {
                Route::get('/', [App\Http\Controllers\Tenant\UserController::class, 'show'])->name('show');
                Route::get('courses', [App\Http\Controllers\Tenant\UserController::class, 'courses'])->name('show.courses');
                Route::post('courses/{course}/result', [App\Http\Controllers\Tenant\UserController::class, 'recordCourseResult'])->name('courses.record-result');
                Route::get('manage-courses', [App\Http\Controllers\Tenant\UserController::class, 'manageCourses'])
                    ->middleware('role:super-admin|Consultant|Qualified Individual')
                    ->name('show.manage-courses');
                Route::patch('course-overrides/{course}', [App\Http\Controllers\Tenant\UserController::class, 'updateCourseOverride'])
                    ->middleware('role:super-admin|Consultant|Qualified Individual')
                    ->name('course-overrides.update');
                Route::get('dot-certificates', [App\Http\Controllers\Tenant\UserController::class, 'dotCertificates'])->name('show.dot-certificates');
                Route::post('dot-certificates', [App\Http\Controllers\Tenant\UserController::class, 'generateDotCertificate'])->name('dot-certificates.generate');
                Route::patch('/', [App\Http\Controllers\Tenant\UserController::class, 'update'])->name('update');
                Route::delete('/', [App\Http\Controllers\Tenant\UserController::class, 'destroy'])->name('destroy');
                Route::post('impersonate', [App\Http\Controllers\Tenant\UserController::class, 'impersonate'])->name('impersonate');
            });
        });

        Route::get('scans', [App\Http\Controllers\Tenant\ScansController::class, 'index'])->middleware(['single.store'])->name('scan.index');
        Route::get('scans/external-finding', [App\Http\Controllers\Tenant\ScansController::class, 'externalFinding'])->middleware(['single.store'])->name('scan.external-finding');
        Route::post('scans/queue-report', [App\Http\Controllers\Tenant\ScansController::class, 'queueReport'])->middleware(['single.store'])->name('scan.queue-report');
        Route::post('scans/refresh-cache', [App\Http\Controllers\Tenant\ScansController::class, 'refreshCache'])->middleware(['single.store'])->name('scan.refresh-cache');

        Route::middleware(['single.store'])->group(function (): void {
            Route::get('scans/settings', [CyrismaController::class, 'settings'])->name('scan.settings');
            Route::put('scans/settings', [CyrismaController::class, 'update'])->name('scan.settings.update');
            Route::get('scans/report/{type}', [CyrismaReportController::class, 'download'])->name('scan.report');
        });

        Route::middleware(['auth', 'single.store'])->group(function (): void {
            Route::get('scans-archive', [App\Http\Controllers\Tenant\ScanArchiveController::class, 'index'])->name('scan.archive');
            Route::post('scans-archive/upload', [App\Http\Controllers\Tenant\ScanArchiveController::class, 'upload'])->name('scan.archive.upload');
        });

        Route::prefix('audits/')->name('audit.')->middleware(['auth', 'single.store'])->group(function (): void {
            Route::get('osha', App\Http\Livewire\Dealer\Audit\Osha\Index::class)->name('osha.index');
            Route::get('osha/{oshaViolationAudit:uuid}/remediation', RemediationForm::class)->name('osha.remediation');
            Route::get('osha/{oshaViolationAudit:uuid}', Single::class)->name('osha.show');
            Route::get('body-shop', App\Http\Livewire\Dealer\Audit\BodyShop\Index::class)->name('body-shop.index');
            Route::get('body-shop/{bodyShopViolationAudit:uuid}/remediation', App\Http\Livewire\Dealer\Audit\BodyShop\RemediationForm::class)->name('body-shop.remediation');
            Route::get('body-shop/{bodyShopViolationAudit:uuid}', App\Http\Livewire\Dealer\Audit\BodyShop\Single::class)->name('body-shop.show');
            Route::get('finance', App\Http\Livewire\Dealer\Audit\Finance\Index::class)->name('finance.index');
            Route::get('/finance/{glbaViolationAudit:uuid}/remediation', App\Http\Livewire\Dealer\Audit\Finance\RemediationForm::class)->name('finance.remediation');
            Route::get('/finance/{glbaViolationAudit:uuid}', App\Http\Livewire\Dealer\Audit\Finance\Single::class)->name('finance.show');
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
