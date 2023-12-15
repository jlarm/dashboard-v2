<?php

declare(strict_types=1);

use App\Http\Controllers\BodyShopAuditController;
use App\Http\Controllers\Dealer\Audit\BodyShopCreateController;
use App\Http\Controllers\Dealer\Audit\FinanceController;
use App\Http\Controllers\Dealer\Audit\IndividualController;
use App\Http\Controllers\Dealer\Audit\IndividualCreateController;
use App\Http\Controllers\Dealer\Audit\OshaCreateController;
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
use App\Http\Controllers\Dealer\ProfileController;
use App\Http\Controllers\Dealer\Store\EmployeeController;
use App\Http\Controllers\Dealer\Store\StoreVendorController;
use App\Http\Controllers\Dealer\StoreController;
use App\Http\Controllers\Dealer\UserController;
use App\Http\Controllers\Dealer\VendorController;
use App\Http\Controllers\FinanceCreateController;
use App\Http\Controllers\OshaAuditController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;


Route::group([
    'as' => 'dealer.',
    'middleware' => [
        'web',
        InitializeTenancyByDomain::class,
        PreventAccessFromCentralDomains::class,
    ],
], function () {

    // **************************************************
    // All Access
    // **************************************************

    Route::get('/language/{locale}', function ($locale) {
        app()->setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    });

    Route::get('/', function () { return view('dealer.welcome'); });

    if(config('app.env') === 'local') {
        Route::get('osha-audit-pdf', \App\Http\Controllers\OshaPdfTestController::class);
        Route::get('deal-jacket-audit-pdf', \App\Http\Controllers\DealJacketPdfTestController::class);
        Route::get('glba-audit-pdf', \App\Http\Controllers\GlbaPdfTestController::class);
        Route::get('body-shop-audit-pdf', \App\Http\Controllers\BodyShopPdfTestController::class);
        Route::Get('dot-cert', function () { return view('dealer.course.CertDownloadView'); });
    }

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');

    Route::get('/dashboard', function () { return view('dealer.dashboard'); })->middleware('auth')->name('dashboard');

    Route::get('invite_registration/{invite:invitation_token}', [UserController::class, 'create'])
        ->missing(function () { return response()->view('errors.link-expired'); })
        ->middleware('web')->name('employees.create');
    Route::post('employees/dealer/store', [UserController::class, 'store'])->name('employees.store');

    Route::group(['prefix' => 'courses/', 'as' => 'courses.'], function () {
        Route::get('/', function () { return view('dealer.course.index'); })->middleware('auth')->name('index');
        Route::get('all', function () { return view('dealer.course.all'); })->middleware(['auth', 'role:super-admin|Consultant'])->name('all');
        Route::get('{course:slug}', [CourseController::class, 'show'])->middleware('auth')->name('show');
        Route::post('{course:slug}', [CourseResultsController::class, 'store'])->middleware('auth')->name('results.store');
        Route::get('{course:slug}/edit', [CourseController::class, 'edit'])->middleware('auth')->name('edit');
        Route::get('{course:slug}/quiz', [CourseController::class, 'quiz'])->middleware('auth')->name('quiz');
    });

    Route::get('vendors/form', [VendorController::class, 'show'])->middleware('signed')->name('vendor.create');
    Route::get('/vendors/thankyou', function () { return view('dealer.vendor.thankyou'); })->middleware('web')->name('vendors.thankyou');

    Route::get('email/settings', \App\Http\Livewire\Dealer\Settings\FrontEndComplianceForm::class)->name('dealer.settings.form')->middleware('signed');

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
    // Roles to Consultant
    // **************************************************

    Route::group(['middleware' => ['role:super-admin|Consultant']], function () {

        Route::group(['prefix' => 'employees/', 'as' => 'employees.'], function () {
            Route::get('create', function () { return view('dealer.employee.create'); })->name('new');
        });

    });

    // **************************************************
    // Roles to Manager
    // **************************************************

    Route::group(['middleware' => ['role:super-admin|Owner|CFO|GM|GSM|Qualified Individual|Manager|Consultant']], function () {

        Route::group(['prefix' => 'employees/', 'as' => 'employees.'], function () {
            Route::get('/', \App\Http\Controllers\Dealer\EmployeeIndexController::class)->name('index');
            Route::get('create', function () { return view('dealer.employee.create'); })->name('new');
            Route::get('open-invites', function () { return view('dealer.employee.open-invites'); })->name('open-invites');
            Route::get('{user:slug}', [UserController::class, 'show'])->name('show');
        });

        Route::get('scans', function () { return view('dealer.scan.index'); })->middleware(['auth', 'single.store'])->name('scan.index');

        Route::group(['prefix' => 'manuals/', 'as' => 'manual.', 'middleware' => ['auth', 'single.store']], function () {
            Route::get('/', \App\Http\Controllers\Dealer\ManualController::class)->name('index');
        });


        Route::group(['prefix' => 'audits/', 'as' => 'audit.', 'middleware' => ['auth', 'single.store']], function () {
            Route::get('osha', function () { return view('dealer.audit.osha.index'); })->name('osha.index');
            Route::get('body-shop', function () { return view('dealer.audit.body-shop.index'); })->name('body-shop.index');
            Route::get('finance', function () { return view('dealer.audit.finance.index'); })->name('finance.index');
            Route::get('deal-jackets', \App\Http\Controllers\Dealer\Audit\IndividualIndexController::class)->name('individual.index');
        });

        Route::get('vendors', [VendorController::class, 'index'])->middleware('auth')->name('vendor.index');

        Route::group(['prefix' => 'docs/', 'as' => 'doc.', 'middleware' => ['auth']], function () {
            Route::get('/', \App\Http\Livewire\Dealer\Docs\Index::class)->name('index');
        });

    });


    // **************************************************
    // Roles to QA
    // **************************************************

    Route::group(['middleware' => ['role:super-admin|Owner|CFO|GM|GSM|Qualified Individual|Consultant']], function () {

        Route::group(['prefix' => 'manuals/', 'as' => 'manual.', 'middleware' => ['auth', 'single.store']], function () {
            Route::get('/isp', \App\Http\Livewire\Dealer\Manual\Isp\Index::class)->name('isp.index');
            Route::get('/isp/create', \App\Http\Livewire\Dealer\Manual\Isp\Create::class)->name('isp.create');
            Route::get('/osha', \App\Http\Livewire\Dealer\Manual\Osha\Index::class)->name('osha.index');
            Route::get('/osha/create', \App\Http\Livewire\Dealer\Manual\Osha\Create::class)->name('osha.create');
            Route::get('/red-flag', App\Http\Livewire\Dealer\Manual\RedFlag\Index::class)->name('red-flag.index');
            Route::get('/red-flag/create', App\Http\Livewire\Dealer\Manual\RedFlag\Create::class)->name('red-flag.create');
            Route::get('cms', \App\Http\Livewire\Dealer\Manual\Cms\Index::class)->name('cms.index');
            Route::get('cms/create', \App\Http\Livewire\Dealer\Manual\Cms\Create::class)->name('cms.create');
        });

        Route::group(['prefix' => 'audits/', 'as' => 'audit.', 'middleware' => ['auth', 'single.store']], function () {
            Route::get('osha/create', OshaCreateController::class)->name('osha.create');
            Route::get('osha/{oshaAudit:id}', OshaAuditController::class)->name('osha.show');
            Route::get('body-shop/create', BodyShopCreateController::class)->name('body-shop.create');
            Route::get('body-shop/{bodyShopAudit:id}', BodyShopAuditController::class)->name('body-shop.show');
            Route::get('finance/create', FinanceCreateController::class)->middleware('can:create-audits')->name('finance.create');
            Route::get('finance/{financeAudit:id}', FinanceController::class)->middleware('can:create-audits')->name('finance.show');
            Route::get('deal-jackets/create/{individualAudit:id?}', IndividualCreateController::class)->name('individual.create');
            Route::get('deal-jackets/{individualAudit:uuid}', IndividualController::class)->name('individual.show');
            Route::get('deal-jackets/{individualAudit:uuid}/edit', \App\Http\Controllers\Dealer\Audit\SingleIndividualController::class)->name('individual.edit');
        });

        Route::get('settings', \App\Http\Controllers\Dealer\Store\SettingsController::class)->middleware(['auth', 'single.store'])->name('dealer.settings');
    });
        Route::get('email/settings', \App\Http\Livewire\Dealer\Settings\FrontEndComplianceForm::class)->middleware('signed')->name('dealer.settings.form');

});

require __DIR__ . '/stores.php';
