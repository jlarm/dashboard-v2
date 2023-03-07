<?php

use App\Http\Controllers\Central\Dealership\CreateController;
use App\Http\Controllers\Central\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('employees/create', [UserController::class, 'create'])->middleware('signed')->name('employees.create');
Route::post('employees/store', [UserController::class, 'store'])->name('employees.store');

Route::group(['middleware' => ['can:delete-users']], function () {
    Route::get('employees', [EmployeeController::class, 'index'])->middleware(['auth', 'verified'])->name('employees.index');
    Route::get('/employees/deleted', function () { return view('central.employee.deleted'); })->middleware(['auth', 'verified'])->name('employees.deleted');
    Route::get('employees/invite', [EmployeeController::class, 'create'])->middleware(['auth', 'verified'])->name('invite.create');
    Route::post('employees/invite', [EmployeeController::class, 'send'])->middleware(['auth', 'verified'])->name('invite.send');
    Route::get('employees/{user}', [EmployeeController::class, 'show'])->middleware(['auth', 'verified'])->name('employees.view');
});

Route::get('/dealerships', function () {
    return view('central.dealership.index');
})->name('dealerships.index')->middleware(['auth', 'verified']);
Route::get('dealerships/create', function () {
return view('central.dealership.create');
})->name('dealerships.create')->middleware(['auth', 'verified']);
Route::post('dealerships/create', CreateController::class)->middleware(['auth', 'verified'])->name('dealerships.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
