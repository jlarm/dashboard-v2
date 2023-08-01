<?php

use App\Http\Controllers\Central\Course\CourseResultsController;
use App\Http\Controllers\Central\Course\QuizController;
use App\Http\Controllers\Central\Course\ShowController;
use App\Http\Controllers\Central\Dealership\CreateController;
use App\Http\Controllers\Central\EmployeeController;
use App\Http\Controllers\Central\Role\EditController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); })->name('home');

Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    Route::get('/dealerships', function () { return view('central.dealership.index'); })->name('dealerships.index');
    Route::get('dealerships/create', function () { return view('central.dealership.create'); })->name('dealerships.create');
    Route::post('dealerships/create', CreateController::class)->name('dealerships.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('courses', function () { return view('central.course.index'); })->name('courses.index');
    Route::get('courses/{course:slug}', ShowController::class)->name('courses.show');
    Route::get('courses/{course:slug}/quiz', QuizController::class)->name('courses.quiz');
    Route::post('courses/{course:slug}/quiz', CourseResultsController::class)->name('courses.quiz.store');

});

Route::get('employees/create', [UserController::class, 'create'])->middleware('signed')->name('employees.create');
Route::post('employees/store', [UserController::class, 'store'])->name('employees.store');

Route::group(['middleware' => ['can:delete-users', 'auth', 'verified']], function () {
    Route::get('employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/deleted', function () { return view('central.employee.deleted'); })->name('employees.deleted');
    Route::get('employees/invite', [EmployeeController::class, 'create'])->name('invite.create');
    Route::post('employees/invite', [EmployeeController::class, 'send'])->name('invite.send');
    Route::get('employees/{user}', [EmployeeController::class, 'show'])->name('employees.view');
    Route::get('roles', function () { return view('central.role.index'); })->name('role.index');
    Route::get('roles/create', function () { return view('central.role.create'); })->name('role.create');
    Route::get('roles/{role:id}', EditController::class)->name('role.edit');
});

require __DIR__.'/auth.php';
