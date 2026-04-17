<?php

declare(strict_types=1);

use App\Http\Controllers\Central\Course\CourseResultsController;
use App\Http\Controllers\Central\DealerDocs\EditController;
use App\Http\Controllers\Central\DealerDocs\IndexController;
use App\Http\Controllers\Central\Dealership\CreateController;
use App\Http\Controllers\Central\Employee\RegisterController;
use App\Http\Controllers\Central\Employee\ShowController;
use App\Http\Controllers\Central\Employee\StoreController;
use App\Http\Controllers\Central\Employee\StoreRegistrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenantLookupController;
use App\Http\Livewire\Central\AuditStatements\Osha\PrintView;
use App\Http\Livewire\Central\Contracts\Create;
use App\Http\Livewire\Central\Contracts\Edit;
use App\Http\Livewire\Central\Contracts\Review;
use App\Http\Livewire\Central\Course\Index;
use App\Http\Livewire\Central\Course\Quiz;
use App\Http\Livewire\Central\Course\Show;
use App\Http\Livewire\Central\CourseManagement\EditQuiz;
use App\Http\Livewire\Central\Dashboard;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified', 'role:super-admin|Consultant'])->group(function (): void {

    Route::inertia('/', 'Welcome')->name('welcome');
    
    //    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::view('dashboard', 'central.dashboard')->name('dashboard');

    Route::prefix('dealerships/')->name('dealerships.')->group(function (): void {
        Route::view('/', 'central.dealership.index')->name('index');
        Route::view('create', 'central.dealership.create')->name('create');
        Route::post('create', CreateController::class)->name('store');
    });

    Route::prefix('contracts/')->name('contracts.')->group(function (): void {
        Route::get('/', App\Http\Livewire\Central\Contracts\Index::class)->name('index');
        Route::get('create', Create::class)->name('create');
        Route::get('{contract:uuid}', Edit::class)->name('edit');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('courses/')->name('courses.')->group(function (): void {
        Route::get('/', Index::class)->name('index');
        Route::get('{course:slug}', Show::class)->name('show');
        Route::get('{course:slug}/quiz', Quiz::class)->name('quiz');
        Route::post('{course:slug}/quiz', CourseResultsController::class)->name('quiz.store');
    });

    Route::get('osha-violations', App\Http\Livewire\Central\AuditStatements\Osha\Index::class)->name('osha-violations.index');
    Route::get('osha-violations/print', PrintView::class)->name('osha-violations.print');
    Route::get('body-shop-violations', App\Http\Livewire\Central\AuditStatements\BodyShop\Index::class)->name('body-shop-violations.index');
    Route::get('body-shop-violations/print', App\Http\Livewire\Central\AuditStatements\BodyShop\PrintView::class)->name('body-shop-violations.print');
    Route::get('glba-violations', App\Http\Livewire\Central\AuditStatements\Glba\Index::class)->name('glba-violations.index');
    Route::get('glba-violations/print', App\Http\Livewire\Central\AuditStatements\Glba\PrintView::class)->name('glba-violations.print');

    Route::get('violation-statements/print', App\Http\Livewire\Central\ViolationStatements\PrintView::class)->name('violation-statements.print');

    Route::get('sds', App\Http\Livewire\Central\Sds\Index::class)->name('sds.index');
    Route::get('sds/create', App\Http\Livewire\Central\Sds\Create::class)->name('sds.create');
    Route::get('sds/{sds:uuid}', App\Http\Livewire\Central\Sds\Edit::class)->name('sds.edit');

    Route::get('documents', App\Http\Livewire\Central\Docs\Index::class)->name('docs.index');
    Route::get('documents/create', App\Http\Livewire\Central\Docs\Create::class)->name('docs.create');

    Route::get('videos', App\Http\Livewire\Global\Video\Index::class)->name('videos.index');
    Route::get('videos/{videoId}', App\Http\Livewire\Global\Video\Show::class)->name('videos.show');

    Route::get('dealer-login', [TenantLookupController::class, 'index'])->name('dealer-login');
    Route::post('dealer-login', [TenantLookupController::class, 'lookup'])->middleware(['throttle:6,1'])->name('dealer-login.lookup');
    Route::get('employees/register', RegisterController::class)->middleware('signed')->name('employees.create');
    Route::post('employees/store', StoreRegistrationController::class)->name('employees.store');
    Route::get('contract/view/{contract:uuid}', Review::class)->middleware('signed')->name('contracts.show');
    Route::view('/thank-you', 'central.contract.review-submitted')->name('thank-you');

    Route::middleware(['role:super-admin'])->group(function (): void {

        Route::prefix('employees/')->name('employees.')->group(function (): void {
            Route::get('/', App\Http\Livewire\Central\Employee\Index::class)->name('index');
            Route::view('deleted', 'central.employee.deleted')->name('deleted');
            Route::get('invite', App\Http\Controllers\Central\Employee\CreateController::class)->name('invite');
            Route::post('invite', StoreController::class)->name('send');
            Route::get('{user:slug}', ShowController::class)->name('view');
        });

        Route::get('dealer-docs', IndexController::class)->name('dealer-docs.index');
        Route::get('dealer-docs/create', App\Http\Controllers\Central\DealerDocs\CreateController::class)->name('dealer-docs.create');
        Route::get('dealer-docs/{sharedDocument}/edit', EditController::class)->name('dealer-docs.edit');

        //    Route::get('roles', \App\Http\Livewire\Central\Role\Index::class)->name('role.index');
        //    Route::get('roles/{role:id}', \App\Http\Livewire\Central\Role\Edit::class)->name('role.edit');
        //
        //    Route::get('permissions', \App\Http\Livewire\Central\Permission\Index::class)->name('permission.index');
        //    Route::get('permissions/{permission:id}', \App\Http\Livewire\Central\Permission\Edit::class)->name('permission.edit');

        //    Route::get('departments', \App\Http\Livewire\Central\Department\Index::class)->name('department.index');
        //    Route::get('departments/{department:id}', \App\Http\Livewire\Central\Department\Edit::class)->name('department.edit');

        Route::get('course-management', App\Http\Livewire\Central\CourseManagement\Index::class)->name('course-management.index');
        Route::get('course-management/{course:slug}', App\Http\Livewire\Central\CourseManagement\Edit::class)->name('course-management.edit');
        Route::get('course-management/quiz/{course:slug}', EditQuiz::class)->name('course-management.edit-quiz');

        Route::get('violation-statements', App\Http\Livewire\Central\ViolationStatements\Index::class)->name('violation-statements.index');
        Route::view('violation-statements/create', 'central.violation-statements.create')->name('violation-statements.create');
        Route::get('violation-statements/{violationStatement}/edit', App\Http\Livewire\Central\ViolationStatements\Edit::class)->name('violation-statements.edit');

        Route::get('osha-violations/create', App\Http\Livewire\Central\AuditStatements\Osha\Create::class)->name('osha-violations.create');
        Route::get('osha-violations/{oshaViolation}', App\Http\Livewire\Central\AuditStatements\Osha\Edit::class)->name('osha-violations.edit');

        Route::get('body-shop-violations/create', App\Http\Livewire\Central\AuditStatements\BodyShop\Create::class)->name('body-shop-violations.create');
        Route::get('body-shop-violations/{bodyShopViolation}', App\Http\Livewire\Central\AuditStatements\BodyShop\Edit::class)->name('body-shop-violations.edit');

        Route::get('glba-violations/create', App\Http\Livewire\Central\AuditStatements\Glba\Create::class)->name('glba-violations.create');
        Route::get('glba-violations/{glbaViolation}', App\Http\Livewire\Central\AuditStatements\Glba\Edit::class)->name('glba-violations.edit');

        Route::get('logs', App\Http\Livewire\Central\Logs\Index::class)->name('logs.index');
    });
});

Route::get('/inertia-welcome', fn () => Inertia::render('Welcome', [
    'message' => 'Hello from Inertia + Vue 3',
]))->name('inertia.welcome');

require __DIR__.'/auth.php';
