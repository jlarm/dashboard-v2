<?php

declare(strict_types=1);

use App\Http\Controllers\Dealer\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Dealer\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Dealer\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Dealer\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Dealer\Auth\NewPasswordController;
use App\Http\Controllers\Dealer\Auth\PasswordController;
use App\Http\Controllers\Dealer\Auth\PasswordResetLinkController;
use App\Http\Controllers\Dealer\Auth\VerifyEmailController;
use App\Http\Controllers\Dealer\ProfileController;
use App\Http\Controllers\Dealer\StoreController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::group([
    'as' => 'dealer.',
    'middleware' => [
        'web',
        InitializeTenancyByDomain::class,
        PreventAccessFromCentralDomains::class,
    ]
], function () {

    Route::get('/', function () {
        return view('dealer.welcome');
    });

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/dashboard', function () {
        return view('dealer.dashboard');
    })->middleware('auth')->name('dashboard');

    Route::get('stores', function () {
        return view('dealer.store.index');
    })->middleware('auth')->name('stores.index');
    Route::get('stores/{store:slug}', [StoreController::class, 'show'])->middleware('auth')->name('stores.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('auth');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->middleware('auth')
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('auth')
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->middleware('auth')
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->middleware('auth')
        ->name('password.store');

    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->middleware('auth')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->middleware('auth')
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store'])->middleware('auth');

    Route::put('password', [PasswordController::class, 'update'])->name('password.update')->middleware('auth');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');

});
