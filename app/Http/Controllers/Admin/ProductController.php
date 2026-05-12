<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Fitur Search (biar admin gampang cari barang)
        if ($request->has('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(10);
        return view('pages.admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_barang'    => 'required|unique:products,nama_barang',
            'category_id'    => 'required|exists:categories,id',
            'harga_jual'     => 'required|numeric|min:0',
            'stok_aktual'    => 'required|integer|min:0',
            'lead_time'      => 'nullable|integer|min:0',
            'rata_penjualan' => 'nullable|integer|min:0',
            'nilai_ss'       => 'nullable|integer|min:0',
            'gambar'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tgl_expired'    => 'nullable|date',
            'tgl_cukai'      => 'nullable|date',
        ]);

        try {
            $data = $request->all();

            // Generate Slug otomatis dari nama barang
            $data['slug'] = Str::slug($request->nama_barang);

            // Logika Checkbox Promo
            $data['is_promo'] = $request->has('is_promo') ? true : false;
            $data['diskon_persen'] = $request->diskon_persen ?? 0;

            // Pastikan kolom inti TA kamu ada nilainya (default 0 jika kosong)
            $data['lead_time'] = $request->lead_time ?? 0;
            $data['rata_penjualan'] = $request->rata_penjualan ?? 0;
            $data['nilai_ss'] = $request->nilai_ss ?? 0;

            // Handle Upload Gambar
            if ($request->hasFile('gambar')) {
                $data['gambar'] = $request->file('gambar')->store('products', 'public');
            }

            // EKSEKUSI SIMPAN
            Product::create($data);

            return redirect()->route('admin.products.index')
                ->with('success', 'Gacor! Produk ' . $request->nama_barang . ' berhasil ditambah.');

        } catch (\Exception $e) {
            // Jika ada error (misal: kolom kurang di $fillable), akan muncul pesan ini
            return back()->withInput()->withErrors(['msg' => 'Gagal Simpan: ' . $e->getMessage()]);
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('pages.admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama_barang'    => 'required|unique:products,nama_barang,' . $product->id,
            'category_id'    => 'required|exists:categories,id',
            'harga_jual'     => 'required|numeric|min:0',
            'stok_aktual'    => 'required|integer|min:0',
            'gambar'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $data = $request->all();
            $data['slug'] = Str::slug($request->nama_barang);
            $data['is_promo'] = $request->has('is_promo') ? true : false;
            
            // Default values untuk kolom numerik
            $data['lead_time'] = $request->lead_time ?? $product->lead_time;
            $data['rata_penjualan'] = $request->rata_penjualan ?? $product->rata_penjualan;
            $data['nilai_ss'] = $request->nilai_ss ?? $product->nilai_ss;

            if ($request->hasFile('gambar')) {
                if ($product->gambar) {
                    Storage::disk('public')->delete($product->gambar);
                }
                $data['gambar'] = $request->file('gambar')->store('products', 'public');
            }

            $product->update($data);

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil diupdate!');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['msg' => 'Gagal Update: ' . $e->getMessage()]);
        }
    }

    public function destroy(Product $product)
    {
        try {
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $product->delete();
            return redirect()->route('admin.products.index')->with('success', 'Produk dihapus!');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Gagal Hapus: ' . $e->getMessage()]);
        }
    }
}