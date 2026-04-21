<?php

declare(strict_types=1);

use App\Http\Controllers\Central\CourseController;
use App\Http\Controllers\Central\CourseResultController;
use App\Http\Controllers\Central\DashboardController;
use App\Http\Controllers\Central\DealershipController;
use App\Http\Controllers\Central\DocumentController;
use App\Http\Controllers\Central\InviteController;
use App\Http\Controllers\Central\SharedDocumentController;
use App\Http\Controllers\Central\UserController;
use App\Http\Controllers\Central\UserInviteRegistrationController;
use App\Http\Controllers\Central\VideoProgressController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['guest', 'signed'])->group(function (): void {
    Route::get('employees/register/{centralUserInvite}', [UserInviteRegistrationController::class, 'create'])
        ->name('employees.create');
    Route::post('employees/register/{centralUserInvite}', [UserInviteRegistrationController::class, 'store'])
        ->name('employees.store');
});

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
});

Route::middleware(['role:super-admin'])->group(function (): void {
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
