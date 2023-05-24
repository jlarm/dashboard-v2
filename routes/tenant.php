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
    Route::get('/', function () { return view('dealer.welcome'); });

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');

    Route::get('/dashboard', function () { return view('dealer.dashboard'); })->middleware('auth')->name('dashboard');

    Route::get('stores', function () { return view('dealer.store.index');})->middleware(['auth', 'has.stores'])->name('stores.index');
    Route::get('settings', function () { return view('dealer.store.settings'); })->middleware(['auth'])->name('dealer.settings');

    Route::group(['prefix' => 'stores/{store:slug}', 'as' => 'stores.'], function () {
        Route::get('employees', \App\Http\Livewire\Dealer\Store\SingleStore\Employee\Index::class)->middleware(['auth', 'has.stores'])->name('employees');
        Route::get('employees/{user:slug}', \App\Http\Livewire\Dealer\Store\SingleStore\Employee\Show::class)->middleware(['auth', 'has.stores'])->name('employees.show');
        Route::get('scans', \App\Http\Livewire\Dealer\Store\SingleStoreScans::class)->middleware(['auth', 'has.stores'])->name('scans');
        Route::get('scan-settings', \App\Http\Livewire\Dealer\Store\SingleStoreScanSettings::class)->middleware(['auth', 'has.stores'])->name('scan-settings');
        Route::get('manuals', \App\Http\Livewire\Dealer\Store\SingleStore\Manual\Index::class)->middleware(['auth', 'has.stores'])->name('manuals');
        Route::get('manuals/isp', \App\Http\Livewire\Dealer\Store\SingleStoreIspForm::class)->middleware(['auth', 'has.stores'])->name('manuals.isp');
        Route::get('manuals/osha', \App\Http\Livewire\Dealer\Store\SingleStoreOshaForm::class)->middleware(['auth', 'has.stores'])->name('manuals.osha');
        Route::get('audits/osha', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Osha\Index::class)->middleware(['auth', 'has.stores'])->name('audits.osha.index');
        Route::get('audits/osha/create', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Osha\Create::class)->middleware(['auth', 'has.stores'])->name('audits.osha.create');
        Route::get('audits/osha/{oshaAudit:id}', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Osha\Show::class)->middleware(['auth', 'has.stores'])->name('audits.osha.show');
        Route::get('audits/body-shop', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\BodyShop\Index::class)->middleware(['auth', 'has.stores'])->name('audits.body-shop.index');
        Route::get('audits/body-shop/create', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\BodyShop\Create::class)->middleware(['auth', 'has.stores'])->name('audits.body-shop.create');
        Route::get('audits/body-shop/{bodyShopAudit:id}', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\BodyShop\Show::class)->middleware(['auth', 'has.stores'])->name('audits.body-shop.show');
        Route::get('audits/finance', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Finance\Index::class)->middleware(['auth', 'has.stores', 'can:create-audits'])->name('audits.finance.index');
        Route::get('audits/finance/create', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Finance\Create::class)->middleware(['auth', 'has.stores'])->name('audits.finance.create');
        Route::get('audits/finance/{financeAudit:id}', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Finance\Show::class)->middleware(['auth', 'has.stores'])->name('audits.finance.show');
        Route::get('settings', \App\Http\Livewire\Dealer\Store\SingleStore\Settings\Index::class)->middleware(['auth', 'has.stores'])->name('settings');
        Route::get('edit', [StoreController::class, 'edit'])->middleware(['auth', 'has.stores'])->name('edit');
    });

    Route::group(['prefix' => 'employees/', 'as' => 'employees.'], function () {
        Route::get('/', function () { return view('dealer.employee.index'); })->middleware('auth')->name('index');
        Route::get('open-invites', function () { return view('dealer.employee.open-invites'); })->middleware('auth')->name('open-invites');
        Route::post('dealer/store', [UserController::class, 'store'])->name('store');
        Route::get('{user:slug}', [UserController::class, 'show'])->middleware('auth')->name('show');
    });

    Route::get('invite_registration/{invite:invitation_token}', [UserController::class, 'create'])->middleware('web')->name('employees.create');

    Route::group(['prefix' => 'store/{store:slug}/', 'as' => 'store.employees.'], function () {
        Route::get('employees', [EmployeeController::class, 'index'])->middleware(['auth', 'has.stores'])->name('store.employee.index');
        Route::get('employees/{user:slug}', [EmployeeController::class, 'show'])->middleware(['auth', 'has.stores'])->name('show');
        Route::get('vendors', [StoreVendorController::class, 'index'])->middleware(['auth', 'has.stores'])->name('store.vendor.index');
        Route::get('scans', function () {
            return view('dealer.store.multi.scan-index');
        })->middleware(['auth', 'has.stores'])->name('store.scan.index');
    });

    Route::group(['prefix' => 'courses/', 'as' => 'courses.'], function () {
        Route::get('/', function () { return view('dealer.course.index'); })->middleware('auth')->name('index');
        Route::get('{course:slug}', [CourseController::class, 'show'])->middleware('auth')->name('show');
        Route::post('{course:slug}', [CourseResultsController::class, 'store'])->middleware('auth')->name('results.store');
        Route::get('{course:slug}/quiz', [CourseController::class, 'quiz'])->middleware('auth')->name('quiz');
    });

    Route::get('scans', function () { return view('dealer.scan.index'); })->middleware('auth')->name('scan.index');
    Route::get('scans/settings', function () { return view('dealer.scan.settings'); })->middleware('auth')->name('scan.settings');

    Route::get('/sds', function () { return view('dealer.sds.index'); })->middleware('auth')->name('sds.index');

    Route::get('/manuals', function () { return view('dealer.manual.index'); })->middleware('auth')->name('manual.index');
    Route::get('/isp', function () { return view('dealer.manual.isp'); })->middleware('auth')->name('manual.isp');
    Route::get('osha', function () { return view('dealer.manual.osha'); })->middleware('auth')->name('manual.osha');

    Route::get('vendors', function () { return view('dealer.vendor.index'); })->middleware('auth')->name('vendor.index');
    Route::get('vendors/form', [VendorController::class, 'show'])->middleware('signed')->name('vendor.create');
    Route::get('/vendors/thankyou', function () { return view('dealer.vendor.thankyou'); })->middleware('web')->name('vendors.thankyou');

    Route::group(['prefix' => 'audits/', 'as' => 'audit.', 'middleware' => 'auth'], function () {
        Route::get('osha', function () { return view('dealer.audit.osha.index'); })->name('osha.index');
        Route::get('osha/create', OshaCreateController::class)->name('osha.create');
        Route::get('osha/{oshaAudit:id}', OshaAuditController::class)->name('osha.show');
        Route::get('body-shop', function () { return view('dealer.audit.body-shop.index'); })->name('body-shop.index');
        Route::get('body-shop/create', BodyShopCreateController::class)->name('body-shop.create');
        Route::get('body-shop/{bodyShopAudit:id}', BodyShopAuditController::class)->name('body-shop.show');
        Route::get('finance', function () { return view('dealer.audit.finance.index'); })->name('finance.index');
        Route::get('finance/create', FinanceCreateController::class)->middleware('can:create-audits')->name('finance.create');
        Route::get('finance/{financeAudit:id}', FinanceController::class)->middleware('can:create-audits')->name('finance.show');
        Route::get('individual', function () { return view('dealer.audit.individual.index'); })->name('individual.index');
        Route::get('individual/create', IndividualCreateController::class)->name('individual.create');
        Route::get('individual/{individualAudit:id}', IndividualController::class)->name('individual.show');
    });

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

});
