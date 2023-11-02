<?php

use App\Http\Controllers\Central\Course\CourseResultsController;
use App\Http\Controllers\Central\Dealership\CreateController;
use App\Http\Controllers\Central\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Central\Course\Index;
use App\Http\Livewire\Central\Course\Quiz;
use App\Http\Livewire\Central\Course\Show;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); })->name('home');

Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/dashboard', \App\Http\Livewire\Central\Dashboard::class)->name('dashboard');

    Route::get('/dealerships', function () { return view('central.dealership.index'); })->name('dealerships.index');
    Route::get('dealerships/create', function () { return view('central.dealership.create'); })->name('dealerships.create');
    Route::post('dealerships/create', CreateController::class)->name('dealerships.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('courses', Index::class)->name('courses.index');
    Route::get('courses/{course:slug}', Show::class)->name('courses.show');
    Route::get('courses/{course:slug}/quiz', Quiz::class)->name('courses.quiz');
    Route::post('courses/{course:slug}/quiz', CourseResultsController::class)->name('courses.quiz.store');

    Route::get('/update', function() {
        $course = \App\Models\Course::findOrFail(1)->update(['name' => 'NESHAP 6-H TEST']);
    });

});

Route::get('employees/create', [UserController::class, 'create'])->middleware('signed')->name('employees.create');
Route::post('employees/store', [UserController::class, 'store'])->name('employees.store');

Route::group(['middleware' => ['can:delete-users', 'auth', 'verified']], function () {
    Route::get('employees', \App\Http\Livewire\Central\Employee\Index::class)->name('employees.index');
    Route::get('/employees/deleted', function () { return view('central.employee.deleted'); })->name('employees.deleted');
    Route::get('employees/invite', [EmployeeController::class, 'create'])->name('invite.create');
    Route::post('employees/invite', [EmployeeController::class, 'send'])->name('invite.send');
    Route::get('employees/{user}', [EmployeeController::class, 'show'])->name('employees.view');

    Route::get('roles', \App\Http\Livewire\Central\Role\Index::class)->name('role.index');
    Route::get('roles/{role:id}', \App\Http\Livewire\Central\Role\Edit::class)->name('role.edit');

    Route::get('permissions', \App\Http\Livewire\Central\Permission\Index::class)->name('permission.index');
    Route::get('permissions/{permission:id}', \App\Http\Livewire\Central\Permission\Edit::class)->name('permission.edit');

    Route::get('departments', \App\Http\Livewire\Central\Department\Index::class)->name('department.index');
    Route::get('departments/{department:id}', \App\Http\Livewire\Central\Department\Edit::class)->name('department.edit');

    Route::get('course-management', \App\Http\Livewire\Central\CourseManagement\Index::class)->name('course-management.index');
    Route::get('course-management/{course:slug}', \App\Http\Livewire\Central\CourseManagement\Edit::class)->name('course-management.edit');
    Route::get('course-management/quiz/{course:slug}', \App\Http\Livewire\Central\CourseManagement\EditQuiz::class)->name('course-management.edit-quiz');
});

require __DIR__.'/auth.php';
