<?php

declare(strict_types=1);

use App\Http\Controllers\Central\ContractController;
use App\Http\Controllers\Central\ContractPdfController;
use App\Http\Controllers\Central\ContractReviewController;
use App\Http\Controllers\Central\ContractSendController;
use App\Http\Controllers\Central\CourseController;
use App\Http\Controllers\Central\CourseManagementController;
use App\Http\Controllers\Central\CourseResultController;
use App\Http\Controllers\Central\DashboardController;
use App\Http\Controllers\Central\DealershipController;
use App\Http\Controllers\Central\DocumentController;
use App\Http\Controllers\Central\InviteController;
use App\Http\Controllers\Central\SdsController;
use App\Http\Controllers\Central\SharedDocumentController;
use App\Http\Controllers\Central\UserController;
use App\Http\Controllers\Central\UserInviteRegistrationController;
use App\Http\Controllers\Central\VideoProgressController;
use App\Http\Controllers\Central\ViolationStatementController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['guest', 'signed'])->group(function (): void {
    Route::get('employees/register/{centralUserInvite}', [UserInviteRegistrationController::class, 'create'])
        ->name('employees.create');
    Route::post('employees/register/{centralUserInvite}', [UserInviteRegistrationController::class, 'store'])
        ->name('employees.store');
});

Route::middleware('signed')->group(function (): void {
    Route::get('contract/view/{contract:uuid}', [ContractReviewController::class, 'show'])->name('contracts.show');
    Route::post('contract/view/{contract:uuid}', [ContractReviewController::class, 'store'])->name('contracts.review.store');
});

Route::get('/thank-you', fn () => Inertia::render('contract/ThankYou'))->name('contracts.thank-you');

Route::middleware(['auth', 'verified', 'role:super-admin|Consultant'])->group(function (): void {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('dealerships', [DealershipController::class, 'index'])->name('dealerships.index');
    Route::post('dealerships', [DealershipController::class, 'store'])->name('dealerships.store');

    Route::prefix('courses/')->name('courses.')->group(function (): void {
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::get('{course:slug}', [CourseController::class, 'show'])->name('show');
        Route::post('{course:slug}/progress', [VideoProgressController::class, 'store'])->name('progress.store');
        Route::get('{course:slug}/quiz', [CourseController::class, 'quiz'])->name('quiz');
        Route::post('{course:slug}/quiz', [CourseResultController::class, 'store'])->name('quiz.store');
    });

    Route::prefix('documents')->name('documents.')->group(function (): void {
        Route::get('/', [DocumentController::class, 'index'])->name('index');
        Route::post('/', [DocumentController::class, 'store'])->name('store');
        Route::get('/{document}/download', [DocumentController::class, 'download'])->name('download');
        Route::delete('/{document}', [DocumentController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('shared-documents')->name('shared-documents.')->group(function (): void {
        Route::get('/', [SharedDocumentController::class, 'index'])->name('index');
        Route::post('/', [SharedDocumentController::class, 'store'])->name('store');
        Route::get('/{sharedDocument}/download', [SharedDocumentController::class, 'download'])->name('download');
        Route::delete('/{sharedDocument}', [SharedDocumentController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('contracts')->name('contracts.')->group(function (): void {
        Route::get('/', [ContractController::class, 'index'])->name('index');
        Route::get('create', [ContractController::class, 'create'])->name('create');
        Route::post('/', [ContractController::class, 'store'])->name('store');
        Route::get('{contract:uuid}', [ContractController::class, 'edit'])->name('edit');
        Route::patch('{contract:uuid}', [ContractController::class, 'update'])->name('update');
        Route::delete('{contract:uuid}', [ContractController::class, 'destroy'])->name('destroy');
        Route::post('{contract:uuid}/send', [ContractSendController::class, 'review'])->name('send');
        Route::post('{contract:uuid}/pdf', [ContractPdfController::class, 'generate'])->name('pdf.generate');
        Route::get('{contract:uuid}/pdf', [ContractPdfController::class, 'download'])->name('pdf.download');
        Route::post('{contract:uuid}/pdf/send', [ContractSendController::class, 'pdf'])->name('pdf.send');
    });

    Route::prefix('sds')->name('sds.')->group(function (): void {
        Route::get('/', [SdsController::class, 'index'])->name('index');
        Route::post('/', [SdsController::class, 'store'])->name('store');
        Route::patch('{sds:uuid}', [SdsController::class, 'update'])->name('update');
        Route::delete('{sds:uuid}', [SdsController::class, 'destroy'])->name('destroy');
        Route::get('{sds:uuid}/download', [SdsController::class, 'download'])->name('download');
    });

    Route::prefix('violation-statements')->name('violation-statements.')->group(function (): void {
        Route::get('/', [ViolationStatementController::class, 'index'])->name('index');
        Route::post('/', [ViolationStatementController::class, 'store'])->name('store');
        Route::patch('{violationStatement}', [ViolationStatementController::class, 'update'])->name('update');
        Route::delete('{violationStatement}', [ViolationStatementController::class, 'destroy'])->name('destroy');
    });
});

Route::middleware(['role:super-admin'])->group(function (): void {
    Route::prefix('course-management')->name('course-management.')->group(function (): void {
        Route::get('/', [CourseManagementController::class, 'index'])->name('index');
        Route::post('import', [CourseManagementController::class, 'import'])->name('import');
        Route::get('{course:slug}', [CourseManagementController::class, 'edit'])->name('edit');
        Route::patch('{course:slug}', [CourseManagementController::class, 'update'])->name('update');
        Route::patch('{course:slug}/quiz', [CourseManagementController::class, 'updateQuiz'])->name('update-quiz');
        Route::patch('{course:slug}/settings', [CourseManagementController::class, 'updateSettings'])->name('update-settings');
    });

    Route::prefix('employees')->name('employees.')->group(function (): void {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('invites', [InviteController::class, 'index'])->name('invites');
        Route::post('invites', [InviteController::class, 'store'])->name('invites.store');
        Route::delete('invites/{invite}', [InviteController::class, 'destroy'])->name('invites.destroy');
        Route::get('deleted', [UserController::class, 'deleted'])->name('deleted');
        Route::get('{user:slug}', [UserController::class, 'show'])->name('show');
    });
});

require __DIR__.'/auth.php';
require __DIR__.'/settings.php';
