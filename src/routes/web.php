<?php

use App\Enums\Roles;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Basket\BasketController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Favorites\FavoritesController;
use App\Http\Controllers\Managers\ManagerController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Profiles\AccountDeleteController;
use App\Http\Controllers\Profiles\ChangeProfileController;
use App\Http\Controllers\Profiles\UserProfileController;
use App\Http\Controllers\Profiles\AdminProfileController;
use App\Http\Controllers\Profiles\ManagerProfileController;
use App\Http\Controllers\Register\RegisterController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('loginForm');
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('throttle:10,1');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('registerForm');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [UserProfileController::class, 'profile'])
        ->name('profile')
        ->middleware('redirect.to.profile');

    Route::get('/admin/profile', [AdminProfileController::class, 'adminProfile'])
        ->name('admin.profile')
        ->middleware('role:' . Roles::ADMIN->value);

    Route::get('/manager/profile', [ManagerProfileController::class, 'managerProfile'])
        ->name('manager.profile')
        ->middleware('role:' . Roles::MANAGER->value);

    Route::patch('/profile', [ChangeProfileController::class, 'updateProfile'])
        ->name('updateProfile');
    Route::get('/email/change/verify/{id}/{token}', [ChangeProfileController::class, 'verifyEmailChange'])
        ->middleware('signed')
        ->name('email.change.verify');
    Route::get('/change-password', [ChangeProfileController::class, 'showChangePasswordForm'])
        ->name('changePasswordForm');
    Route::post('/change-password', [ChangeProfileController::class, 'changePassword'])
        ->name('changePassword')
        ->middleware('throttle:6,1');

    Route::delete('/account/delete', [AccountDeleteController::class, 'destroy'])
        ->name('account.delete')
        ->middleware(['ensure.user.can.delete.account', 'throttle:6,1']);

    Route::get('/basket', [BasketController::class, 'index'])->name('basket.index');
    Route::post('/basket', [BasketController::class, 'store'])->name('basket.store');
    Route::delete('/basket/{id}', [BasketController::class, 'destroy'])->name('basket.destroy');

    Route::get('/favorites', [FavoritesController::class, 'index'])->name('favorites.index');
    Route::post('/favorites', [FavoritesController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{id}', [FavoritesController::class, 'destroy'])->name('favorites.destroy');
    Route::post('/favorites/remove', [FavoritesController::class, 'removeByProduct'])->name('favorites.removeByProduct');

    Route::middleware('role:' . Roles::ADMIN->value . '|' . Roles::MANAGER->value)->group(function () {
        Route::prefix('products')->group(function () {
            Route::get('/manage', [ProductController::class, 'index'])->name('products.index');
            Route::get('/create', [ProductController::class, 'create'])->name('products.create');
            Route::post('/', [ProductController::class, 'store'])->name('products.store');
            Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
            Route::patch('/{product}', [ProductController::class, 'update'])->name('products.update');
            Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        });
    });

    Route::middleware('role:' . Roles::ADMIN->value)->group(function () {
        Route::resource('managers', ManagerController::class)->except(['show', 'edit', 'update']);
        Route::resource('categories', CategoryController::class)->except(['show']);
    });

    Route::middleware('role:' . Roles::MANAGER->value)->group(function () {
        Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
    });
});

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
