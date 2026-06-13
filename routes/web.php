<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use Illuminate\Support\Facades\Route;

// Redirect root to shop
Route::get('/', function () {
    return redirect()->route('front.home');
});

// Authentication Routes (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Shared Protected Routes
Route::middleware(['role:admin,user'])->group(function () {
    Route::get('/info', [DashboardController::class, 'index'])->name('dashboard');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::post('/addresses', [UserAddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{address}', [UserAddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [UserAddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/{address}/default', [UserAddressController::class, 'setDefault'])->name('addresses.set-default');
});

// Admin Only Routes
Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.users.index');
    });
    Route::patch('users/{user}/role', [UserController::class, 'updateRole'])->name('users.update-role');
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('products/bulk', [ProductController::class, 'bulkCreate'])->name('products.bulk-create');
    Route::post('products/bulk', [ProductController::class, 'bulkStore'])->name('products.bulk-store');
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update', 'destroy']);
});

// ===================== FRONTEND (PUBLIC) =====================

// Home - banner + bestsellers preview
Route::get('/shop', [HomeController::class, 'index'])->name('front.home');

// Full shop catalog with search & filter
Route::get('/all-products', [HomeController::class, 'shop'])->name('front.shop');

// All bestsellers page
Route::get('/bestsellers', [HomeController::class, 'bestsellers'])->name('front.bestsellers');

// About us
Route::get('/about', [HomeController::class, 'about'])->name('front.about');

// Product detail
Route::get('/product/{slug}', [HomeController::class, 'show'])->name('front.product.show');

// Cart (session-based)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{key}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{key}', [CartController::class, 'destroy'])->name('destroy');
});

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/thankyou', [CheckoutController::class, 'thankYou'])->name('thankyou');
