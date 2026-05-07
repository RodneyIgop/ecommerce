<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Business\BusinessController;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/products', [ProductController::class, 'index'])->name('products');

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'handle']);

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/businesses', [AdminController::class, 'businesses'])->name('admin.businesses');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::patch('/products/{product}/status', [AdminController::class, 'updateProductStatus'])->name('admin.products.status');
    Route::get('/revenue', [AdminController::class, 'revenue'])->name('admin.revenue');
    Route::post('/revenue', [AdminController::class, 'updateRevenueSettings'])->name('admin.revenue.update');
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.status');
    Route::get('/disputes', [AdminController::class, 'disputes'])->name('admin.disputes');
    Route::patch('/disputes/{dispute}', [AdminController::class, 'updateDispute'])->name('admin.disputes.update');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::patch('/users/{user}/status', [AdminController::class, 'toggleUserStatus'])->name('admin.users.status');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
    Route::get('/verifications', [AdminController::class, 'verifications'])->name('admin.verifications');
    Route::patch('/verifications/{profile}', [AdminController::class, 'updateVerification'])->name('admin.verifications.update');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
});

Route::middleware(['auth', 'business'])->prefix('business')->group(function () {
    Route::get('/dashboard', [BusinessController::class, 'index'])->name('business.dashboard');
    Route::get('/products', [BusinessController::class, 'products'])->name('business.products');
    Route::post('/products', [BusinessController::class, 'storeProduct'])->name('business.products.store');
    Route::get('/products/{product}/edit', [BusinessController::class, 'editProduct'])->name('business.products.edit');
    Route::put('/products/{product}', [BusinessController::class, 'updateProduct'])->name('business.products.update');
    Route::post('/products/{product}/archive', [BusinessController::class, 'archiveProduct'])->name('business.products.archive');
    Route::get('/products/archived', [BusinessController::class, 'archivedProducts'])->name('business.products.archived');
    Route::post('/products/{product}/restore', [BusinessController::class, 'restoreProduct'])->name('business.products.restore');
    Route::delete('/products/{product}', [BusinessController::class, 'deleteProduct'])->name('business.products.delete');
    Route::get('/orders', [BusinessController::class, 'orders'])->name('business.orders');
    Route::patch('/orders/{order}/status', [BusinessController::class, 'updateOrderStatus'])->name('business.orders.status');
    Route::get('/sales', [BusinessController::class, 'sales'])->name('business.sales');
});

Route::middleware(['auth', 'buyer'])->prefix('buyer')->group(function () {
    Route::get('/dashboard', [BuyerController::class, 'index'])->name('buyer.dashboard');
});



