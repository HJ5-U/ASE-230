<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| These routes handle all user-facing and admin-facing endpoints.
| Includes authentication, dashboard access, student management, and profiles.
|
*/

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard Route (Home)
|--------------------------------------------------------------------------
|
| The dashboard serves as the main landing page after login.
| Displays user info, system stats, and provides navigation to other modules.
|
*/
Route::get('/', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Student Management Routes
|--------------------------------------------------------------------------
|
| Handles all CRUD operations for Student records.
| Includes listing, searching, creating, updating, and deleting students.
|
*/
Route::middleware('auth')->group(function () {

    // Show the student list page or JSON results if AJAX request
    Route::get('/students', [StudentController::class, 'index'])
        ->name('students.index');

    // Student filtering routes
    Route::get('/students/by-name/{name}', [StudentController::class, 'getByName'])
        ->name('students.byName');

    Route::get('/students/by-course/{course}', [StudentController::class, 'getByCourse'])
        ->name('students.byCourse');

    Route::get('/students/by-major/{major}', [StudentController::class, 'getByMajor'])
        ->name('students.byMajor');

    Route::get('/students/by-year/{year}', [StudentController::class, 'getByYear'])
        ->name('students.byYear');

    // Show individual student (for AJAX search by ID)
    Route::get('/students/{id}', [StudentController::class, 'show'])
        ->name('students.show');

    // Add a new student
    Route::post('/students', [StudentController::class, 'store'])
        ->name('students.store');

    // Update an existing student
    Route::put('/students/{id}', [StudentController::class, 'update'])
        ->name('students.update');

    // Delete a specific student
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])
        ->name('students.destroy');

    // Delete all students — admin only
    Route::delete('/students', [StudentController::class, 'destroyAll'])
        ->middleware(\App\Http\Middleware\AdminMiddleware::class)
        ->name('students.destroyAll');
});

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
|
| Provides profile management and password update routes for authenticated users.
|
*/
Route::middleware('auth')->group(function () {

    // Show profile editing form
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    // Update profile info (PATCH)
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    // Delete user account
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Update password
    Route::put('/user/password', [ProfileController::class, 'updatePassword'])
        ->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Restricted routes for admin users only.
| Allows user management and bulk student operations.
|
*/
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->group(function () {

    // Admin dashboard for managing users
    Route::get('/users', [AdminController::class, 'index'])
        ->name('admin.users');

    // Toggle user activation status
    Route::post('/users/toggle', [AdminController::class, 'toggleStatus'])
        ->name('admin.users.toggle');

    // Add a new user
    Route::post('/users', [AdminController::class, 'store'])
        ->name('admin.users.store');

    // Delete a user by ID
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])
        ->name('admin.users.destroy');

    // Admin action: delete all students
    Route::delete('/students/delete-all', [StudentController::class, 'destroyAll'])
        ->name('admin.students.deleteAll');
});

// Include authentication routes (register, password reset, etc.)
require __DIR__.'/auth.php';





