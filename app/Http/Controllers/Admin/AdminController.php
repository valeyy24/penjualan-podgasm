<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\StockRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stokKritis = Product::whereColumn('stok_aktual', '<=', 'nilai_ss')->get();
        $jumlahKritis = $stokKritis->count();

        $totalPenjualan = Transaction::whereDate('created_at', today())->sum('total_harga');

        // Pastikan memanggil 'tgl_cukai' sesuai nama kolom di database
        $potensiKerugian = Product::where('tgl_expired', '<', now()->addDays(30))
                                    ->orWhere('tgl_cukai', '<', now()->subYear())
                                    ->get()
                                    ->sum(function($product) {
                                        return $product->stok_aktual * $product->harga_jual;
                                    });

        return view('pages.admin.dashboard', compact(
            'stokKritis', 
            'jumlahKritis', 
            'totalPenjualan', 
            'potensiKerugian'
        ));
    }

    public function index()
    {
        $pendingCount = StockRequest::where('status', 'Pending')->count();
        
        if ($pendingCount > 0) {
            session()->now('warning', "Ada $pendingCount permintaan stok baru yang perlu diproses!");
        }

        return view('pages.admin.dashboard');
    }
}