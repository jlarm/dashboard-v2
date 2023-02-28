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
use App\Http\Controllers\Dealer\CourseController;
use App\Http\Controllers\Dealer\CourseResultsController;
use App\Http\Controllers\Dealer\ProfileController;
use App\Http\Controllers\Dealer\StoreController;
use App\Http\Controllers\Dealer\UserController;
use App\Http\Controllers\Dealer\VendorController;
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
    })->middleware(['auth', 'has.stores'])->name('stores.index');
    Route::get('stores/{store:slug}', [StoreController::class, 'show'])->middleware(['auth', 'has.stores'])->name('stores.show');

    Route::get('employees', function () {
        return view('dealer.employee.index');
    })->middleware('auth')->name('employees.index');
    Route::get('employees/open-invites', function () {
        return view('dealer.employee.open-invites');
    })->middleware('auth')->name('employees.open-invites');
    Route::get('invite_registration/{invite:invitation_token}', [UserController::class, 'create'])->middleware('web')->name('employees.create');
    Route::post('employees/dealer/store', [UserController::class, 'store'])->name('dealer.employees.store');
    Route::get('employees/{user:id}', [UserController::class, 'show'])->middleware('auth')->name('employees.show');
    Route::get('abc', [CourseResultsController::class, 'export'])->middleware(['web', 'auth'])->name('dealer.employees.export');

    Route::get('courses', function () {
        return view('dealer.course.index');
    })->middleware('auth')->name('courses.index');
    Route::get('courses/{course:slug}', [CourseController::class, 'show'])->middleware('auth')->name('courses.show');
    Route::post('courses/{course:slug}', [CourseResultsController::class, 'store'])->middleware('auth')->name('courses.results.store');
    Route::get('courses/{course:slug}/quiz', [CourseController::class, 'quiz'])->middleware('auth')->name('courses.quiz');

    Route::get('scans', function () {
        return view('dealer.scan.index');
    })->middleware('auth')->name('scan.index');

    Route::get('/sds', function () {
        return view('dealer.sds.index');
    })->middleware('auth')->name('sds.index');

    Route::get('/manuals', function () {
        return view('dealer.manual.index');
    })->middleware('auth')->name('manual.index');
    Route::get('/glbform', function () {
        return view('dealer.manual.GlbForm');
    })->middleware('auth')->name('manual.glbform');

    Route::get('vendors', function () {
    return view('dealer.vendor.index');
    })->middleware('auth')->name('vendor.index');
    Route::get('vendors/form', [VendorController::class, 'index'])->middleware('signed')->name('vendor.create');

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
