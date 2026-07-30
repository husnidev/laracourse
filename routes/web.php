<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');
Route::get('/login', function(){
    return view('login');
});
Route::get('/register', function(){
    return view('register');
});
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
