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
use App\Http\Controllers\Branch\BranchController;
use App\Http\Controllers\Admin\StockRequestController;

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
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


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

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.') // INI KUNCINYA! Biar semua route di bawah otomatis punya prefix 'admin.'
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Manajemen Produk
        Route::resource('products', ProductController::class)->except(['show']);

        // Algoritma Safety Stock
        Route::controller(SafetyStockController::class)->group(function () {
            Route::get('/safety-stock', 'index')->name('ss.index');
            Route::post('/safety-stock/calculate/{id}', 'calculate')->name('ss.calculate');
        });

        // Manajemen Permintaan Stok Cabang (Approval)
        Route::controller(StockRequestController::class)->group(function () {
            Route::get('/stock-requests', 'index')->name('stock-requests.index');
            Route::post('/stock-requests/{id}/approve', 'approve')->name('stock-requests.approve');
            Route::post('/stock-requests/{id}/reject', 'reject')->name('stock-requests.reject');
        });

        // Laporan
        Route::get('/reports/inventory', [ReportController::class, 'inventoryReport'])->name('reports.inventory');

    }
);

/*
|--------------------------------------------------------------------------
| BRANCH / CABANG ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:branch']) // Pastikan user login & rolenya branch
    ->prefix('branch')
    ->as('branch.')
    ->group(function () {
        
        // Halaman Dashboard Utama Cabang
        Route::get('/dashboard', [BranchController::class, 'dashboard'])->name('dashboard');

        // Fitur Request Stock (Form & Simpan)
        Route::get('/request-stock', [BranchController::class, 'index'])->name('request');
        Route::post('/request-stock', [BranchController::class, 'storeRequest'])->name('request.store');

        // Fitur Monitoring / Tracking
        Route::get('/tracking', [BranchController::class, 'tracking'])->name('tracking');

    });