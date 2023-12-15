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
    'as' => 'dealer.stores.',
    'middleware' => [
        'web',
        InitializeTenancyByDomain::class,
        PreventAccessFromCentralDomains::class,
    ],
], function () {

    Route::group(['prefix' => 'stores/{store:slug}', 'middleware' => ['stores', 'has.stores', 'auth']], function () {

        Route::get('/', \App\Http\Livewire\Dealer\Store\SingleStore\Home\Index::class)->name('home');

        // **************************************************
        // Roles to Manager
        // **************************************************
        Route::group(['middleware' => ['role:super-admin|Owner|CFO|GM|GSM|Qualified Individual|Manager|Consultant']], function () {

            Route::get('employees', \App\Http\Livewire\Dealer\Store\SingleStore\Employee\Index::class)->name('employees');
            Route::get('employees/create', \App\Http\Livewire\Dealer\Store\SingleStore\Employee\Create::class)->name('employee.create');
            Route::get('/employees/open-invites', \App\Http\Livewire\Dealer\Store\SingleStore\Employee\OpenInvites::class)->name('employees.open-invites');
            Route::get('employees/{user:slug}', \App\Http\Livewire\Dealer\Store\SingleStore\Employee\Show::class)->name('employees.show');

            Route::get('scans', \App\Http\Livewire\Dealer\Store\SingleStore\Scan\Index::class)->middleware(['auth', 'has.stores'])->name('scan.index');

            Route::get('manuals', \App\Http\Livewire\Dealer\Store\SingleStore\Manual\Index::class)->name('manuals');

            Route::get('audits/osha', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Osha\Index::class)->name('audits.osha.index');
            Route::get('audits/body-shop', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\BodyShop\Index::class)->name('audits.body-shop.index');
            Route::get('audits/finance', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Finance\Index::class)->name('audits.finance.index');
            Route::get('audits/deal-jackets', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Individual\Index::class)->name('audits.individual.index');

            Route::get('vendors', \App\Http\Livewire\Dealer\Store\SingleStore\Vendor\Index::class)->name('vendor.index');

            Route::get('docs', \App\Http\Livewire\Dealer\Store\SingleStore\Docs\Index::class)->name('doc.index');

        });

        // **************************************************
        // Roles to QA
        // **************************************************
        Route::group(['middleware' => ['role:super-admin|Owner|CFO|GM|GSM|Qualified Individual|Consultant']], function () {

            Route::get('manuals/isp', \App\Http\Livewire\Dealer\Manual\Isp\Index::class)->name('manuals.isp.index');
            Route::get('manuals/isp/create', \App\Http\Livewire\Dealer\Manual\Isp\Create::class)->name('manuals.isp.create');
            Route::get('manuals/osha', \App\Http\Livewire\Dealer\Manual\Osha\Index::class)->name('manuals.osha.index');
            Route::get('manuals/osha/create', \App\Http\Livewire\Dealer\Manual\Osha\Create::class)->name('manuals.osha.create');
            Route::get('manuals/red-flag', \App\Http\Livewire\Dealer\Manual\RedFlag\Index::class)->name('manuals.red-flag.index');
            Route::get('manuals/red-flag/create', \App\Http\Livewire\Dealer\Manual\RedFlag\Create::class)->name('manuals.red-flag.create');
            Route::get('manuals/cms', \App\Http\Livewire\Dealer\Manual\Cms\Index::class)->name('manuals.cms.index');
            Route::get('manuals/cms/create', \App\Http\Livewire\Dealer\Manual\Cms\Create::class)->name('manuals.cms.create');

            Route::get('audits/osha/create', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Osha\Create::class)->name('audits.osha.create');
            Route::get('audits/osha/{oshaAudit:id}', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Osha\Show::class)->name('audits.osha.show');
            Route::get('audits/body-shop/create', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\BodyShop\Create::class)->name('audits.body-shop.create');
            Route::get('audits/body-shop/{bodyShopAudit:id}', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\BodyShop\Show::class)->name('audits.body-shop.show');
            Route::get('audits/finance/create', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Finance\Create::class)->name('audits.finance.create');
            Route::get('audits/finance/{financeAudit:id}', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Finance\Show::class)->name('audits.finance.show');
            Route::get('audits/deal-jackets/create/{individualAudit:uuid?}', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Individual\Create::class)->name('audits.individual.create');
            Route::get('audits/deal-jackets/{individualAudit:uuid}', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Individual\Show::class)->name('audits.individual.show');
            Route::get('audits/deal-jackets/{individualAudit:uuid}/edit', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Individual\Edit::class)->name('audits.individual.edit');

            Route::get('settings', \App\Http\Livewire\Dealer\Store\SingleStore\Settings\Index::class)->name('settings');

            Route::get('edit', [StoreController::class, 'edit'])->name('edit');

        });

    });

});
