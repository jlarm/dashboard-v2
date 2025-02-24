<?php

declare(strict_types=1);

use App\Http\Controllers\Dealer\Audit\BodyShopCreateController;
use App\Http\Controllers\Dealer\Audit\IndividualController;
use App\Http\Controllers\Dealer\Audit\IndividualCreateController;
use App\Http\Controllers\Dealer\Audit\IndividualIndexController;
use App\Http\Controllers\Dealer\Audit\OshaCreateController;
use App\Http\Controllers\Dealer\Audit\SingleIndividualController;
use App\Http\Controllers\Dealer\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Dealer\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Dealer\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Dealer\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Dealer\Auth\NewPasswordController;
use App\Http\Controllers\Dealer\Auth\PasswordController;
use App\Http\Controllers\Dealer\Auth\PasswordResetLinkController;
use App\Http\Controllers\Dealer\Auth\VerifyEmailController;
use App\Http\Controllers\Dealer\CourseController;
use App\Http\Controllers\Dealer\CourseResultsController;
use App\Http\Controllers\Dealer\EmployeeIndexController;
use App\Http\Controllers\Dealer\ManualController;
use App\Http\Controllers\Dealer\ProfileController;
use App\Http\Controllers\Dealer\Store\SettingsController;
use App\Http\Controllers\Dealer\UserController;
use App\Http\Controllers\Dealer\VendorController;
use App\Http\Livewire\Dealer\Audit\Osha\Edit;
use App\Http\Livewire\Dealer\Audit\Osha\Single;
use App\Http\Livewire\Dealer\Docs\Index;
use App\Http\Livewire\Dealer\Employee\DeletedIndex;
use App\Http\Livewire\Dealer\Settings\FrontEndComplianceForm;
use App\Http\Livewire\Tenant\Employee\Show;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::name('dealer.')->middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    // **************************************************
    // All Access
    // **************************************************

    //    Route::get('/language/{locale}', function ($locale) {
    //        app()->setLocale($locale);
    //        session()->put('locale', $locale);
    //
    //        return redirect()->back();
    //    });

    Route::view('/', 'dealer.welcome');

    if (config('app.env') === 'local') {
        Route::get('osha-audit-pdf', \App\Http\Controllers\OshaPdfTestController::class);
        Route::get('deal-jacket-audit-pdf', \App\Http\Controllers\DealJacketPdfTestController::class);
        Route::get('glba-audit-pdf', \App\Http\Controllers\GlbaPdfTestController::class);
        Route::get('body-shop-audit-pdf', \App\Http\Controllers\BodyShopPdfTestController::class);
        Route::Get('dot-cert', function () {
            return view('dealer.course.CertDownloadView');
        });
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

    Route::get('invite_registration/{invite:invitation_token}', [UserController::class, 'create'])
        ->missing(function () {
            return response()->view('errors.link-expired');
        })
        ->middleware('web')->name('employees.create');
    Route::post('employees/dealer/store', [UserController::class, 'store'])->name('employees.store');

    Route::prefix('courses/')->name('courses.')->group(function () {
        Route::view('/', 'dealer.course.index')->middleware('auth')->name('index');
        Route::view('all', 'dealer.course.all')->middleware(['auth', 'role:super-admin|Consultant'])->name('all');
        Route::get('{course:slug}', [CourseController::class, 'show'])->middleware('auth')->name('show');
        Route::post('{course:slug}', [CourseResultsController::class, 'store'])->middleware('auth')->name('results.store');
        Route::get('{course:slug}/edit', [CourseController::class, 'edit'])->middleware('auth')->name('edit');
        Route::get('{course:slug}/quiz', [CourseController::class, 'quiz'])->middleware('auth')->name('quiz');
    });

    Route::get('vendors/form', [VendorController::class, 'show'])->middleware('signed')->name('vendor.create');
    Route::get('form', \App\Http\Livewire\Dealer\Vendor\NewForm::class)->middleware('signed')->name('vendor.form');
    Route::view('/vendors/thankyou', 'dealer.vendor.thankyou')->middleware('web')->name('vendors.thankyou');

//    Route::view('disclosures', 'dealer.disclosure.index')->middleware(['auth', 'web'])->name('disclosure.index');

    Route::get('email/settings', FrontEndComplianceForm::class)->name('dealer.settings.form')->middleware('signed');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('auth');

    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])->middleware('auth')->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->middleware('auth')->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store'])->middleware('auth');
    Route::put('password', [PasswordController::class, 'update'])->name('password.update')->middleware('auth');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

    // **************************************************
    // Roles to Super Admin
    // **************************************************

    Route::middleware('role:super-admin')->group(function () {
        Route::get('global-settings', \App\Http\Livewire\Dealer\Settings\GlobalSettings::class)->name('settings.global');
    });

    // **************************************************
    // Roles to Consultant
    // **************************************************

    Route::middleware('role:super-admin|Consultant')->group(function () {

        Route::prefix('employees/')->name('employees.')->group(function () {
            Route::view('create', 'dealer.employee.create')->name('new');
        });

        Route::prefix('audits/')->name('audit.')->middleware(['auth'])->group(function () {
            Route::get('osha/create/{store}', OshaCreateController::class)->name('osha.create');
            Route::get('osha/{oshaViolationAudit:uuid}/edit', Edit::class)->name('osha.edit');
            Route::get('body-shop/create/{store}', BodyShopCreateController::class)->name('body-shop.create');
            Route::get('body-shop/{bodyShopViolationAudit:uuid}/edit', \App\Http\Livewire\Dealer\Audit\BodyShop\Edit::class)->name('body-shop.edit');
            Route::get('finance/create/{store}', \App\Http\Controllers\Dealer\Audit\FinanceCreateController::class)->middleware('can:create-audits')->name('finance.create');
            Route::get('finance/{glbaViolationAudit:uuid}/edit', \App\Http\Livewire\Dealer\Audit\Finance\Edit::class)->name('finance.edit');
            Route::get('deal-jackets/create/{individualAudit:id?}', IndividualCreateController::class)->name('individual.create');
            Route::get('deal-jackets/{individualAudit:uuid}', IndividualController::class)->name('individual.show');
            Route::get('deal-jackets/{individualAudit:uuid}/edit', SingleIndividualController::class)->name('individual.edit');
        });

        Route::get('phishing/create', \App\Http\Livewire\Dealer\Phish\Create::class)->name('phishing.create');

        Route::get('logs', \App\Http\Livewire\Dealer\Log\Index::class)->name('logs.index');
        Route::get('logs/{activity:id}', \App\Http\Livewire\Dealer\Log\Show::class)->name('logs.show');

        Route::get('ridgeback', \App\Http\Livewire\Dealer\Ridgeback\Index::class)->name('ridgeback.index');

    });

    // **************************************************
    // Roles to QA
    // **************************************************

    Route::middleware('role:super-admin|Consultant|Owner|CFO|GM|GSM|Qualified Individual')->group(function () {

        Route::get('employees/deleted', DeletedIndex::class)->name('employee.deleted');

        Route::prefix('manuals/')->name('manual.')->middleware(['auth', 'single.store'])->group(function () {
            Route::get('/isp', \App\Http\Livewire\Dealer\Manual\Isp\Index::class)->name('isp.index');
            Route::get('/isp/create', \App\Http\Livewire\Dealer\Manual\Isp\Create::class)->name('isp.create');
            Route::get('/osha', \App\Http\Livewire\Dealer\Manual\Osha\Index::class)->name('osha.index');
            Route::get('/osha/create', \App\Http\Livewire\Dealer\Manual\Osha\Create::class)->name('osha.create');
            Route::get('/red-flag', \App\Http\Livewire\Dealer\Manual\RedFlag\Index::class)->name('red-flag.index');
            Route::get('/red-flag/create', \App\Http\Livewire\Dealer\Manual\RedFlag\Create::class)->name('red-flag.create');
            Route::get('cms', \App\Http\Livewire\Dealer\Manual\Cms\Index::class)->name('cms.index');
            Route::get('cms/create', \App\Http\Livewire\Dealer\Manual\Cms\Create::class)->name('cms.create');
        });

        Route::get('settings', SettingsController::class)->middleware(['auth', 'single.store'])->name('dealer.settings');

        Route::get('phishing', App\Http\Livewire\Dealer\Phish\Index::class)->name('phishing.index');
        Route::get('phishing/{phishingCampaign}', App\Http\Livewire\Dealer\Phish\Show::class)->name('phishing.show');
    });

    // **************************************************
    // Roles to Manager
    // **************************************************

    Route::middleware('role:super-admin|Consultant|Owner|CFO|GM|GSM|Qualified Individual|Manager')->group(function () {

        Route::prefix('employees/')->name('employees.')->group(function () {
            Route::get('/', EmployeeIndexController::class)->name('index');
            Route::view('create', 'dealer.employee.create')->name('new');
            Route::view('open-invites', 'dealer.employee.open-invites')->name('open-invites');
            Route::get('{user:slug}', [UserController::class, 'show'])->name('show');
        });

        Route::view('scans', 'dealer.scan.index')->middleware(['auth', 'single.store'])->name('scan.index');

        Route::prefix('audits/')->name('audit.')->middleware(['auth'])->group(function () {
            Route::get('osha', \App\Http\Livewire\Dealer\Audit\Osha\Index::class)->name('osha.index');
            Route::get('osha/{oshaViolationAudit:uuid}/remediation', \App\Http\Livewire\Dealer\Audit\Osha\RemediationForm::class)->name('osha.remediation');
            Route::get('osha/{oshaViolationAudit:uuid}', Single::class)->name('osha.show');
            Route::get('body-shop', \App\Http\Livewire\Dealer\Audit\BodyShop\Index::class)->name('body-shop.index');
            Route::get('body-shop/{bodyShopViolationAudit:uuid}/remediation', \App\Http\Livewire\Dealer\Audit\BodyShop\RemediationForm::class)->name('body-shop.remediation');
            Route::get('body-shop/{bodyShopViolationAudit:uuid}', \App\Http\Livewire\Dealer\Audit\BodyShop\Single::class)->name('body-shop.show');
            Route::get('finance', \App\Http\Livewire\Dealer\Audit\Finance\Index::class)->name('finance.index');
            Route::get('/finance/{glbaViolationAudit:uuid}/remediation', \App\Http\Livewire\Dealer\Audit\Finance\RemediationForm::class)->name('finance.remediation');
            Route::get('/finance/{glbaViolationAudit:uuid}', \App\Http\Livewire\Dealer\Audit\Finance\Single::class)->name('finance.show');
            Route::get('deal-jackets', IndividualIndexController::class)->name('individual.index');
        });

        Route::get('vendors', \App\Http\Livewire\Dealer\Vendor\Index::class)->middleware('auth')->name('vendor.index');

        Route::prefix('documents/')->name('doc.')->middleware('auth')->group(function () {
            Route::get('/', Index::class)->name('index');
        });

        Route::get('fit-tests', \App\Http\Livewire\Tenant\Audit\Fit\Index::class)->name('fit-tests.index');

    });

    Route::get('email/settings', FrontEndComplianceForm::class)->middleware('signed')->name('dealer.settings.form');

});

Route::middleware([
    'api',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::post('/webhooks/gophish/', 'App\Http\Controllers\WebhookController@gophish')->name('webhooks.gophish');
});

require __DIR__.'/stores.php';
