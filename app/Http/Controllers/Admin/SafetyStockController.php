<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SafetyStockController extends Controller
{
    /**
     * Menampilkan daftar produk untuk dihitung SS-nya
     */
    public function index()
    {
        // Mengambil produk agar Admin bisa memilih mana yang mau dihitung
        $products = Product::with('category')->get();
        return view('pages.admin.safety-stock.calculation', compact('products'));
    }

    /**
     * Menjalankan Algoritma Safety Stock & ROP
     */
    public function calculate(Request $request, $id)
    {
        $request->validate([
            'lead_time' => 'required|numeric',
            'max_sales' => 'required|numeric',
            'avg_sales' => 'required|numeric',
        ]);

        $product = Product::findOrFail($id);

        // --- RUMUS ALGORITMA ---
        // 1. Safety Stock (SS) = (Penjualan Max - Penjualan Rata-rata) * Lead Time
        $safetyStock = ($request->max_sales - $request->avg_sales) * $request->lead_time;

        // 2. Reorder Point (ROP) = (Penjualan Rata-rata * Lead Time) + Safety Stock
        $rop = ($request->avg_sales * $request->lead_time) + $safetyStock;

        // Update ke Database
        $product->update([
            'nilai_ss'       => $safetyStock,
            'lead_time'      => $request->lead_time,
            'rata_penjualan' => $request->avg_sales,
            // Kamu bisa simpan ROP di kolom lain jika perlu, atau gunakan nilai_ss sebagai acuan alert
        ]);

        return redirect()->back()->with('success', 'Perhitungan Safety Stock ' . $product->nama_barang . ' berhasil diperbarui!');
    }
}
