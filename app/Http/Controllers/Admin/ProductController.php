<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Tambahkan ini untuk generate slug

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filter == 'latest') {
            $query->latest();
        }

        // Gunakan pagination agar tampilan admin tetap rapi
        $products = $query->paginate(10);

        return view('pages.admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|unique:products,nama_barang',
            'category_id' => 'required',
            'harga_jual'   => 'required|numeric',
            'stok_aktual'  => 'required|numeric',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->all();

        // 🔥 REVISI 1: Generate Slug otomatis
        $data['slug'] = Str::slug($request->nama_barang);

        // 🔥 REVISI 2: Logika Promo (set default jika tidak dicentang)
        $data['is_promo'] = $request->has('is_promo');

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambah!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('pages.admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama_barang' => 'required|unique:products,nama_barang,' . $product->id,
            'category_id' => 'required',
            'harga_jual'   => 'required|numeric',
            'stok_aktual'  => 'required|numeric',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->all();
        
        // Update Slug jika nama barang berubah
        $data['slug'] = Str::slug($request->nama_barang);
        
        // Logika Promo
        $data['is_promo'] = $request->has('is_promo');

        if ($request->hasFile('gambar')) {
            // hapus gambar lama jika ada
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            // simpan gambar baru
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Product $product)
    {
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}