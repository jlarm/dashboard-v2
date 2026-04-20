<?php

declare(strict_types=1);

use App\Http\Controllers\Central\DashboardController;
use App\Http\Controllers\Central\DealershipController;
use App\Http\Controllers\Central\InviteController;
use App\Http\Controllers\Central\UserController;
use App\Http\Controllers\Central\UserInviteRegistrationController;
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
