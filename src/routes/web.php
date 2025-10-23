<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('loginForm');
    Route::post('/login', 'login')->name('login');
    Route::get('/logout', 'logout')->name('logout');
    Route::post('/logout', 'logout')->name('logout');
    Route::get('/register', 'showRegisterForm')->name('registerForm');
    Route::post('/register', 'register')->name('register');
    Route::get('/profile', 'profile')->name('profile');
    Route::patch('/profile', 'updateProfile')->name('updateProfile');
    Route::get('/change-password', 'showChangePasswordForm')->name('changePasswordForm');
    Route::post('/change-password', 'changePassword')->name('changePassword');
});


