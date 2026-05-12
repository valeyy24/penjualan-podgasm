<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class BranchStock extends Model
{
    protected $fillable = ['user_id', 'produk_id', 'stok_lokal'];

    public function produk() {
        return $this->belongsTo(Product::class);
    }

    public function index()
    {
        // 1. Ambil semua data produk buat dipilih di form request
        // Gunakan 'Product' atau 'Produk' sesuai nama Model kamu ya!
        $products = Product::all(); 

        // 2. Kirim variabel $products ke view pakai compact
        return view('pages.branch.request-stock', compact('products'));
    }
}
