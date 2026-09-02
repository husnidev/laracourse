<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseModuleController;
use App\Http\Controllers\ManageQuizController;
use App\Http\Controllers\StudentController;

Route::get('/login', function(){
    return view('login');
});
Route::get('/register', function(){
    return view('register');
});
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
Route::post('/register', [RegisterController::class, 'store'])->name('register');

Route::middleware('auth')->group(function () {
    // Define authenticated routes here
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class)->only(['index', 'store', 'update']);
    Route::post('users/{user}/update_status', [UserController::class, 'update_status'])->name('users.update_status');
    Route::get('users/{id}/delete', [UserController::class, 'delete'])->name('users.delete');
    Route::post('users/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulkDelete');
    // categories routes
    Route::resource('categories', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
    // courses routes
    Route::resource('courses', CourseController::class);
    // course modules routes
    Route::resource('manage-courses', CourseModuleController::class)->except(['destroy']);
    Route::delete('manage-courses/{module}', [CourseModuleController::class, 'destroy'])
    ->name('manage-courses.destroy');
    // lessons routes
    Route::post('manage-course/create_lesson', [CourseModuleController::class, 'create_lesson'])->name('manage-courses.create_lesson');
    Route::put('manage-course/update_lesson', [CourseModuleController::class, 'update_lesson'])->name('manage-courses.update_lesson');
    Route::delete('manage-course/delete_lesson', [CourseModuleController::class, 'delete_lesson'])->name('manage-courses.delete_lesson');
    Route::post('manage-course/create_quiz', [CourseModuleController::class, 'create_quiz'])->name('manage-courses.create_quiz');
    Route::put('manage-course/update_quiz', [CourseModuleController::class, 'update_quiz'])->name('manage-courses.update_quiz');
    Route::delete('manage-course/delete_quiz', [CourseModuleController::class, 'delete_quiz'])->name('manage-courses.delete_quiz');
    Route::post('manage-course/create_assignment', [CourseModuleController::class, 'create_assignment'])->name('manage-courses.create_assignment');
    Route::put('manage-course/update_assignment', [CourseModuleController::class, 'update_assignment'])->name('manage-courses.update_assignment');
    Route::delete('manage-course/delete_assignment', [CourseModuleController::class, 'delete_assignment'])->name('manage-courses.delete_assignment');
    Route::get('manage-quiz/{quiz_id}', [ManageQuizController::class, 'index'])->name('manage-quiz.index');
    Route::post('manage-quiz/create', [ManageQuizController::class, 'store'])->name('manage-quiz.store');
    Route::delete('manage-quiz/delete', [ManageQuizController::class, 'destroy'])->name('manage-quiz.delete');
    // students routes
    Route::get('students', [StudentController::class, 'index'])->name('students.index');
});
