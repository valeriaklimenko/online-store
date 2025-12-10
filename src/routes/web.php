<?php

use App\Enums\Roles;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Managers\ManagerController;
use App\Http\Controllers\Product\ProductController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/', function (Request $request) {
    $categories = Category::orderBy('name')->get();
    $productsQuery = Product::with(['images', 'category'])->latest();

    $activeCategory = null;
    if ($request->filled('category')) {
        $activeCategory = $categories->firstWhere('slug', $request->category);
        if ($activeCategory) {
            $productsQuery->where('category_id', $activeCategory->id);
        }
    }

    $products = $productsQuery->take(6)->get();

    return view('welcome', compact('products', 'categories', 'activeCategory'));
})->name('home');

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('loginForm');
    Route::post('/login', 'login')->name('login');
    Route::get('/register', 'showRegisterForm')->name('registerForm');
    Route::post('/register', 'register')->name('register');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [AuthController::class, 'profile'])
        ->name('profile')
        ->middleware('redirect.to.profile');

    Route::get('/admin/profile', [AuthController::class, 'adminProfile'])
        ->name('admin.profile')
        ->middleware('role:' . Roles::ADMIN->value);

    Route::get('/manager/profile', [AuthController::class, 'managerProfile'])
        ->name('manager.profile')
        ->middleware('role:' . Roles::MANAGER->value);

    Route::get('/user/profile', [AuthController::class, 'profile'])
        ->name('user.profile');

    Route::patch('/profile', [AuthController::class, 'updateProfile'])->name('updateProfile');
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('changePasswordForm');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('changePassword');

    Route::middleware('role:' . Roles::ADMIN->value . '|' . Roles::MANAGER->value)->group(function () {
        Route::get('/products/manage', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    Route::middleware('role:' . Roles::ADMIN->value)->group(function () {
        Route::resource('managers', ManagerController::class)->except(['show', 'edit', 'update']);
    });

    Route::middleware('role:' . Roles::MANAGER->value)->group(function () {
        Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
    });
});

Route::get('/products/{product}', [ProductController::class, 'show'])
    ->name('products.show');
