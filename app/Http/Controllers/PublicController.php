<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        // 1. Mengambil semua kategori untuk Mega Menu
        $categories = Category::all();
        
        // 2. Mengambil produk terbaru (Non-Promo) untuk grid utama
        $products = Product::where('is_promo', false)
                            ->latest()
                            ->take(8)
                            ->get();

        // 3. Mengambil produk khusus promo untuk _promo-banner
        $promoProducts = Product::where('is_promo', true)
                                ->take(4)
                                ->get();

        // 4. LOGIKA BARU: Menghitung jumlah total produk di keranjang (Session)
        $cart = session()->get('cart', []);
        $cartCount = 0;
        
        foreach ($cart as $item) {
            // Kita menjumlahkan 'quantity' agar jika beli 1 barang 2 pcs, angka di navbar muncul 2
            $cartCount += $item['quantity'];
        }
        $wishlistCount = session()->get('wishlist') ? count(session()->get('wishlist')) : 0;
        // 5. Kirim semua variabel ke view
        return view('pages.public.index', compact(
            'categories', 
            'products', 
            'promoProducts', 
            'cartCount',
            'wishlistCount' // Variabel ini yang akan dipakai di Navbar
        ));
    }

    public function categoryIndex($slug)
    {
        // Cari kategori berdasarkan slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // Ambil produk yang termasuk dalam kategori tersebut
        $products = Product::where('category_id', $category->id)
                            ->latest()
                            ->paginate(12); // Menggunakan pagination agar tidak berat

        return view('pages.public.catalog', compact('category', 'products'));
    }
}