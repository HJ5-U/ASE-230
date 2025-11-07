<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| This file defines API routes for external access (mobile apps, SPA frontends,
| or Postman clients). All sensitive routes are protected using Laravel Sanctum.
| Public routes are limited to registration and login.
|
*/

/*
|--------------------------------------------------------------------------
| Public Authentication Routes
|--------------------------------------------------------------------------
|
| These endpoints are accessible without authentication.
| They allow user registration and login using Sanctum tokens.
|
*/
Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']); // normal user registration
    Route::post('/login', [AuthController::class, 'login']); // login -> issues Sanctum token
});


/*
|--------------------------------------------------------------------------
| Protected Routes (auth:sanctum)
|--------------------------------------------------------------------------
|
| These routes require valid Sanctum tokens for access.
| They allow interaction with Students and User profiles.
|
*/
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Students API Endpoints
    |--------------------------------------------------------------------------
    |
    | Provides full CRUD operations on the Student model.
    | Example usage:
    |   GET    /api/v1/students
    |   GET    /api/v1/students/{id}
    |   POST   /api/v1/students
    |   PUT    /api/v1/students/{id}
    |   DELETE /api/v1/students/{id}
    |
    */
    Route::get('/students', [StudentController::class, 'index'])->name('api.students.index');
    Route::get('/students/{id}', [StudentController::class, 'show'])->name('api.students.show');
    Route::post('/students', [StudentController::class, 'store'])->name('api.students.store');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('api.students.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('api.students.destroy');

    /*
    |--------------------------------------------------------------------------
    | Student Filtering Endpoints
    |--------------------------------------------------------------------------
    |
    | Provides filtering capabilities for students by various attributes.
    | Example usage:
    |   GET    /api/v1/students/by-name/{name}
    |   GET    /api/v1/students/by-course/{course}
    |   GET    /api/v1/students/by-major/{major}
    |   GET    /api/v1/students/by-year/{year}
    |
    */
    Route::get('/students/by-name/{name}', [StudentController::class, 'getByName'])->name('api.students.byName');
    Route::get('/students/by-course/{course}', [StudentController::class, 'getByCourse'])->name('api.students.byCourse');
    Route::get('/students/by-major/{major}', [StudentController::class, 'getByMajor'])->name('api.students.byMajor');
    Route::get('/students/by-year/{year}', [StudentController::class, 'getByYear'])->name('api.students.byYear');

    /*
    |--------------------------------------------------------------------------
    | User Profile Endpoints
    |--------------------------------------------------------------------------
    |
    | Allows authenticated users to view and update their profiles.
    |
    */
    Route::get('/user', [UserController::class, 'profile'])->name('api.user.profile');
    Route::put('/user/update', [UserController::class, 'updateProfile'])->name('api.user.update');

    /*
    |--------------------------------------------------------------------------
    | Admin-Only Endpoints
    |--------------------------------------------------------------------------
    |
    | These routes require both authentication AND admin privileges.
    | You can enforce admin restrictions using a middleware like 'admin'.
    |
    */
    Route::middleware('admin')->group(function () {

        Route::delete('/students/delete-all', [StudentController::class, 'destroyAll'])
            ->name('api.admin.destroyAllStudents');
            
    });

    /*
    |--------------------------------------------------------------------------
    | Logout Endpoint
    |--------------------------------------------------------------------------
    |
    | Allows users to revoke their current Sanctum token (logout).
    |
    */
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
});

