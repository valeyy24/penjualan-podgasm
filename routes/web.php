<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SafetyStockController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/category/{slug}', [PublicController::class, 'categoryIndex'])->name('public.category');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| CART & CHECKOUT
|--------------------------------------------------------------------------
*/

Route::prefix('cart')->group(function () {

    Route::get('/', [CartController::class, 'index'])->name('cart.index');

    Route::post('/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');

    Route::patch('/update', [CartController::class, 'updateCart'])->name('cart.update');

    Route::delete('/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');

});

/*
|--------------------------------------------------------------------------
| CHECKOUT
|--------------------------------------------------------------------------
*/

Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/checkout/process', [CartController::class, 'processCheckout'])
    ->name('cart.processCheckout');
Route::get('/history', [OrderController::class, 'history'])->name('order.history');
Route::get('/history/{id}', [OrderController::class, 'show'])->name('order.show');

/*
|--------------------------------------------------------------------------
| WISHLIST
|--------------------------------------------------------------------------
*/

Route::prefix('wishlist')->group(function () {

    Route::get('/', [CartController::class, 'wishlist'])->name('wishlist.index');

    Route::get('/add/{id}', [CartController::class, 'addToWishlist'])->name('wishlist.add');

    Route::delete('/remove/{id}', [CartController::class, 'removeFromWishlist'])->name('wishlist.remove');

});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Produk
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    });

    // Safety Stock
    Route::get('/safety-stock', [SafetyStockController::class, 'index'])->name('admin.ss.index');
    Route::post('/safety-stock/calculate/{id}', [SafetyStockController::class, 'calculate'])->name('admin.ss.calculate');

    // Report
    Route::get('/reports/inventory', [ReportController::class, 'inventoryReport'])->name('admin.reports.inventory');
});

/*
|--------------------------------------------------------------------------
| BRANCH
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:branch'])
    ->prefix('branch')
    ->group(function () {
        // future branch routes
    });