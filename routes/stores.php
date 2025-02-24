<?php

declare(strict_types=1);

use App\Http\Controllers\Dealer\StoreController;
use App\Http\Livewire\Dealer\Employee\DeletedIndex;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::name('dealer.stores.')->middleware('web', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class)->group(function () {

    Route::prefix('stores/{store:slug}')->middleware(['stores', 'has.stores', 'auth', 'canAccessStore'])->group(function () {

        Route::get('/', \App\Http\Livewire\Dealer\Store\SingleStore\Home\Index::class)->name('home');

        // **************************************************
        // Roles to Consultant
        // **************************************************
        Route::middleware('role:super-admin|Consultant')->group(function () {
            Route::get('audits/osha/create', \App\Http\Controllers\Dealer\Audit\OshaCreateController::class)->name('audits.osha.create');
            Route::get('audits/osha/{oshaViolationAudit:uuid}/edit', \App\Http\Livewire\Dealer\Audit\Osha\Edit::class)->name('audits.osha.edit');
            Route::get('audits/body-shop/create', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\BodyShop\Create::class)->name('audits.body-shop.create');
            Route::get('audits/body-shop/{bodyShopViolationAudit:uuid}/edit', \App\Http\Livewire\Dealer\Audit\BodyShop\Edit::class)->name('audits.body-shop.edit');
            Route::get('audits/finance/create', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Finance\Create::class)->name('audits.finance.create');
            Route::get('audits/finance/{glbaViolationAudit:uuid}/edit', \App\Http\Livewire\Dealer\Audit\Finance\Edit::class)->name('audits.finance.edit');
            Route::get('audits/deal-jackets/create/{individualAudit:uuid?}', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Individual\Create::class)->name('audits.individual.create');
            Route::get('audits/deal-jackets/{individualAudit:uuid}/edit', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Individual\Edit::class)->name('audits.individual.edit');

            Route::get('settings', \App\Http\Livewire\Dealer\Store\SingleStore\Settings\Index::class)->name('settings');

            Route::get('edit', [StoreController::class, 'edit'])->name('edit');

            Route::get('ridgeback', \App\Http\Livewire\Dealer\Ridgeback\Index::class)->name('ridgeback.index');

        });

        // **************************************************
        // Roles to Manager
        // **************************************************
        Route::middleware('role:super-admin|Consultant|Owner|CFO|GM|GSM|Qualified Individual|Manager')->group(function () {

            Route::get('employees', \App\Http\Livewire\Dealer\Store\SingleStore\Employee\Index::class)->name('employees');
            Route::get('employees/create', \App\Http\Livewire\Dealer\Store\SingleStore\Employee\Create::class)->name('employee.create');
            Route::get('/employees/open-invites', \App\Http\Livewire\Dealer\Store\SingleStore\Employee\OpenInvites::class)->name('employees.open-invites');
            Route::get('employees/{user:slug}', \App\Http\Livewire\Dealer\Store\SingleStore\Employee\Show::class)->name('employees.show');

            Route::get('scans', \App\Http\Livewire\Dealer\Store\SingleStore\Scan\Index::class)->middleware(['auth', 'has.stores'])->name('scan.index');

            Route::get('manuals', \App\Http\Livewire\Dealer\Store\SingleStore\Manual\Index::class)->name('manuals');
            Route::get('audits/osha', \App\Http\Livewire\Dealer\Audit\Osha\Index::class)->name('audits.osha.index');
            Route::get('audits/body-shop', \App\Http\Livewire\Dealer\Audit\BodyShop\Index::class)->name('audits.body-shop.index');
            Route::get('audits/finance', \App\Http\Livewire\Dealer\Audit\Finance\Index::class)->name('audits.finance.index');
            Route::get('audits/deal-jackets', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Individual\Index::class)->name('audits.individual.index');

            Route::get('osha/{oshaViolationAudit:uuid}/remediation', \App\Http\Livewire\Dealer\Audit\Osha\RemediationForm::class)->name('audits.osha.remediation');
            Route::get('osha/{oshaViolationAudit:uuid}', \App\Http\Livewire\Dealer\Audit\Osha\Single::class)->name('audits.osha.view');
            Route::get('body-shop/{bodyShopViolationAudit:uuid}/remediation', \App\Http\Livewire\Dealer\Audit\BodyShop\RemediationForm::class)->name('audits.body-shop.remediation');
            Route::get('body-shop/{bodyShopViolationAudit:uuid}', \App\Http\Livewire\Dealer\Audit\BodyShop\Single::class)->name('audits.body-shop.view');
            Route::get('/finance/{glbaViolationAudit:uuid}/remediation', \App\Http\Livewire\Dealer\Audit\Finance\RemediationForm::class)->name('audits.finance.remediation');
            Route::get('finance/{glbaViolationAudit:uuid}', \App\Http\Livewire\Dealer\Audit\Finance\Single::class)->name('audits.finance.view');
            Route::get('audits/deal-jackets/{individualAudit:uuid}', \App\Http\Livewire\Dealer\Store\SingleStore\Audit\Individual\Show::class)->name('audits.individual.show');

            Route::get('vendors', \App\Http\Livewire\Dealer\Vendor\Index::class)->name('vendor.index');

            Route::get('documents', \App\Http\Livewire\Dealer\Store\SingleStore\Docs\Index::class)->name('doc.index');

            Route::get('fit-tests', \App\Http\Livewire\Tenant\Audit\Fit\Index::class)->name('fit-tests.index');

        });

        // **************************************************
        // Roles to QA
        // **************************************************
        Route::middleware('role:super-admin|Consultant|Owner|CFO|GM|GSM|Qualified Individual')->group(function () {

            Route::get('deleted-employees', DeletedIndex::class)->name('employee.deleted');

            Route::get('manuals/isp', \App\Http\Livewire\Dealer\Manual\Isp\Index::class)->name('manuals.isp.index');
            Route::get('manuals/isp/create', \App\Http\Livewire\Dealer\Manual\Isp\Create::class)->name('manuals.isp.create');
            Route::get('manuals/osha', \App\Http\Livewire\Dealer\Manual\Osha\Index::class)->name('manuals.osha.index');
            Route::get('manuals/osha/create', \App\Http\Livewire\Dealer\Manual\Osha\Create::class)->name('manuals.osha.create');
            Route::get('manuals/red-flag', \App\Http\Livewire\Dealer\Manual\RedFlag\Index::class)->name('manuals.red-flag.index');
            Route::get('manuals/red-flag/create', \App\Http\Livewire\Dealer\Manual\RedFlag\Create::class)->name('manuals.red-flag.create');
            Route::get('manuals/cms', \App\Http\Livewire\Dealer\Manual\Cms\Index::class)->name('manuals.cms.index');
            Route::get('manuals/cms/create', \App\Http\Livewire\Dealer\Manual\Cms\Create::class)->name('manuals.cms.create');

            Route::get('settings', \App\Http\Livewire\Dealer\Store\SingleStore\Settings\Index::class)->name('settings');

            Route::get('edit', [StoreController::class, 'edit'])->name('edit');

        });

    });

});
