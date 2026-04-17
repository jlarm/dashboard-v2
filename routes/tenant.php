<?php

declare(strict_types=1);

use App\Http\Controllers\WebhookController;
use App\Http\Controllers\BodyShopPdfTestController;
use App\Http\Controllers\Dealer\Audit\BodyShopCreateController;
use App\Http\Controllers\Dealer\Audit\FinanceCreateController;
use App\Http\Controllers\Dealer\Audit\IndividualController;
use App\Http\Controllers\Dealer\Audit\IndividualCreateController;
use App\Http\Controllers\Dealer\Audit\IndividualIndexController;
use App\Http\Controllers\Dealer\Audit\OshaCreateController;
use App\Http\Controllers\Dealer\Audit\SingleIndividualController;
use App\Http\Controllers\Dealer\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Dealer\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Dealer\Auth\NewPasswordController;
use App\Http\Controllers\Dealer\Auth\PasswordController;
use App\Http\Controllers\Dealer\Auth\PasswordResetLinkController;
use App\Http\Controllers\Dealer\CourseController;
use App\Http\Controllers\Dealer\CourseResultsController;
use App\Http\Controllers\Dealer\EmployeeIndexController;
use App\Http\Controllers\Dealer\ImpersonationController;
use App\Http\Controllers\Dealer\ProfileController;
use App\Http\Controllers\Dealer\Store\CreateFirstStoreController;
use App\Http\Controllers\Dealer\Store\SettingsController;
use App\Http\Controllers\Dealer\StoreController;
use App\Http\Controllers\Dealer\UserController;
use App\Http\Controllers\Dealer\VendorController;
use App\Http\Controllers\DealJacketPdfTestController;
use App\Http\Controllers\DealJacketReportPdfTestController;
use App\Http\Controllers\GlbaPdfTestController;
use App\Http\Controllers\OshaPdfTestController;
use App\Http\Controllers\Tenant\Audit\DealJacketController;
use App\Http\Controllers\Tenant\Audit\DealJacketGroupController;
use App\Http\Controllers\Tenant\Audit\DealJacketReportDownloadController;
use App\Http\Controllers\Tenant\CyrismaController;
use App\Http\Controllers\Tenant\CyrismaReportController;
use App\Http\Controllers\Tenant\SdsController;
use App\Http\Livewire\Dealer\Audit\Osha\Edit;
use App\Http\Livewire\Dealer\Audit\Osha\RemediationForm;
use App\Http\Livewire\Dealer\Audit\Osha\Single;
use App\Http\Livewire\Dealer\Docs\Index;
use App\Http\Livewire\Dealer\Employee\DeletedIndex;
use App\Http\Livewire\Dealer\Log\Show;
use App\Http\Livewire\Dealer\Phish\Create;
use App\Http\Livewire\Dealer\Settings\AutomatedReports;
use App\Http\Livewire\Dealer\Settings\FrontEndComplianceForm;
use App\Http\Livewire\Dealer\Settings\GlobalSettings;
use App\Http\Livewire\Dealer\Vendor\NewForm;
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

    Route::view('/', 'dealer.welcome');

    if (app()->environment('local')) {
        Route::get('osha-audit-pdf', OshaPdfTestController::class);
        Route::get('deal-jacket-audit-pdf', DealJacketPdfTestController::class);
        Route::get('deal-jacket-report-pdf', DealJacketReportPdfTestController::class);
        Route::get('glba-audit-pdf', GlbaPdfTestController::class);
        Route::get('body-shop-audit-pdf', BodyShopPdfTestController::class);
        Route::Get('dot-cert', fn () => view('dealer.course.CertDownloadView'));
    }

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');

    Route::get('language/{locale}', function ($locale) {
        app()->setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    })->middleware('auth');

    Route::view('/dashboard', 'dealer.dashboard')->middleware('auth')->name('dashboard');
    Route::post('/dashboard/first-store', CreateFirstStoreController::class)->middleware('auth')->name('store.first');

    Route::any('stores/{path?}', static fn () => redirect()->route('dealer.dashboard'))
        ->where('path', '.*')
        ->name('legacy-stores.redirect');

    Route::get('invite_registration/{invite:invitation_token}', [UserController::class, 'create'])
        ->missing(fn () => response()->view('errors.link-expired'))
        ->middleware('web')->name('employees.create');
    Route::post('employees/dealer/store', [UserController::class, 'store'])->name('employees.store');

    Route::view('sds-sheets', 'tenant.sds.index')->middleware('auth')->name('sds.index');
    Route::get('sds-sheets/{uuid}/view', [SdsController::class, 'view'])->middleware('auth')->name('sds.view');

    Route::prefix('courses/')->name('courses.')->group(function (): void {
        Route::view('/', 'dealer.course.index')->middleware('auth')->name('index');
        Route::view('all', 'dealer.course.all')->middleware(['auth', 'role:super-admin|Consultant'])->name('all');
        Route::get('{course:slug}', [CourseController::class, 'show'])->middleware('auth')->name('show');
        Route::post('{course:slug}', [CourseResultsController::class, 'store'])->middleware('auth')->name('results.store');
        //        Route::get('{course:slug}/edit', [CourseController::class, 'edit'])->middleware('auth')->name('edit');
        Route::get('{course:slug}/quiz', [CourseController::class, 'quiz'])->middleware('auth')->name('quiz');
    });

    Route::get('vendors/form', [VendorController::class, 'show'])->middleware('signed')->name('vendor.create');
    Route::get('form', NewForm::class)->middleware('signed')->name('vendor.form');
    Route::view('/vendors/thankyou', 'dealer.vendor.thankyou')->middleware('web')->name('vendors.thankyou');

    Route::get('email/settings', FrontEndComplianceForm::class)->name('dealer.settings.form')->middleware('signed');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('auth');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->middleware('auth')->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store'])->middleware('auth');
    Route::put('password', [PasswordController::class, 'update'])->name('password.update')->middleware('auth');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

    // **************************************************
    // Roles to Super Admin
    // **************************************************

    Route::middleware('role:super-admin')->group(function (): void {
        Route::get('global-settings', GlobalSettings::class)->name('settings.global');
        Route::prefix('global-settings')->name('settings.global.')->group(function (): void {
            Route::get('course-management', GlobalSettings::class)
                ->defaults('section', 'course-management')
                ->name('course-management');
            Route::get('reset-courses', GlobalSettings::class)
                ->defaults('section', 'reset-courses')
                ->name('reset-courses');
            Route::get('phishing', GlobalSettings::class)
                ->defaults('section', 'phishing')
                ->name('phishing');
        });
    });

    Route::middleware('role:super-admin|Consultant|Owner|GM|CFO|GSM|Qualified Individual')
        ->get('automated-reports', AutomatedReports::class)
        ->name('settings.automated-reports');

    // **************************************************
    // Roles to Consultant
    // **************************************************

    Route::middleware('role:super-admin|Consultant')->group(function (): void {

        Route::prefix('employees/')->name('employees.')->group(function (): void {
            Route::view('create', 'dealer.employee.create')->name('new');
        });

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

        Route::get('ridgeback', App\Http\Livewire\Dealer\Ridgeback\Index::class)
            ->middleware(['auth', 'single.store'])
            ->name('ridgeback.index');

        Route::view('locations', 'tenant.store.index')->name('locations.index');

    });

    Route::middleware(['auth', 'permission:delete-stores'])->group(function (): void {
        Route::get('logs', App\Http\Livewire\Dealer\Log\Index::class)->name('logs.index');
        Route::get('logs/{activity:id}', Show::class)->name('logs.show');
    });

    // **************************************************
    // Roles to QA
    // **************************************************

    Route::middleware('role:super-admin|Consultant|Owner|CFO|GM|GSM|Qualified Individual')->group(function (): void {

        Route::get('employees/deleted', DeletedIndex::class)->name('employees.deleted');

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

        Route::prefix('employees/')->name('employees.')->group(function (): void {
            Route::get('/', EmployeeIndexController::class)->name('index');
            Route::view('create', 'dealer.employee.create')->name('new');
            Route::view('open-invites', 'dealer.employee.open-invites')->name('open-invites');
            Route::prefix('{user:slug}')->group(function (): void {
                Route::get('/', [UserController::class, 'show'])->name('show');
                Route::get('manage-courses', [UserController::class, 'showManageCourses'])
                    ->middleware('role:super-admin|Consultant|Qualified Individual')
                    ->name('show.manage-courses');
                Route::get('certificates', [UserController::class, 'showCertificates'])->name('show.certificates');
                Route::get('video-progress', [UserController::class, 'showVideoProgress'])->name('show.video-progress');
            });
        });

        Route::get('scans', App\Http\Livewire\Tenant\Scans\Index::class)->middleware(['single.store'])->name('scan.index');

        Route::middleware(['single.store'])->group(function (): void {
            Route::get('scans/settings', [CyrismaController::class, 'settings'])->name('scan.settings');
            Route::get('scans/report/{type}', [CyrismaReportController::class, 'download'])->name('scan.report');
        });

        Route::view('scans-archive', 'dealer.scan.index')->middleware(['auth', 'single.store'])->name('scan.archive');

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

        Route::get('vendors', App\Http\Livewire\Dealer\Vendor\Index::class)->middleware('auth')->name('vendor.index');

        Route::prefix('documents/')->name('doc.')->middleware('auth')->group(function (): void {
            Route::get('/', Index::class)->name('index');
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
    Route::post('/webhooks/gophish/', [App\Http\Controllers\WebhookController::class, 'gophish'])->name('webhooks.gophish');
});
