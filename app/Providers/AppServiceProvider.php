<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\StockRequest; // WAJIB: Import Model StockRequest
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Pastikan tidak error saat migrate atau running via terminal
        if (!app()->runningInConsole()) {
            
            // 1. Bagian Kategori (Yang sudah ada)
            if (Schema::hasTable('categories')) {
                $categories = Category::with('children')->whereNull('parent_id')->get();
                View::share('categories', $categories);
            }

            // 2. Bagian Notifikasi Admin (TAMBAHKAN INI)
            if (Schema::hasTable('stock_requests')) {
                // Kita ambil jumlah request yang statusnya masih 'Pending'
                $pendingRequestCount = StockRequest::where('status', 'Pending')->count();
                
                // Kita share variabel ini ke seluruh view (bisa diakses di sidebar)
                View::share('pendingRequestCount', $pendingRequestCount);
            }
        }
    }
}