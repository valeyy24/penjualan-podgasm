<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\BranchStock;
use App\Models\Category;
use App\Models\StockRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    // Tampilkan Form Request & Daftar Produk
    public function index()
    {
        // Ambil produk yang stoknya masih ada di pusat (opsional filter)
        $products = Product::orderBy('nama_barang', 'asc')->get();
        return view('pages.branch.request-stock', compact('products'));
    }

    // Simpan Permintaan Stok
    public function storeRequest(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:products,id',
            'jumlah' => 'required|numeric|min:1',
            'prioritas' => 'required|in:Low,Normal,High',
        ]);

        try {
            StockRequest::create([
                // Pastikan nama kolom ini SAMA dengan migration stock_requests kamu
                'produk_id' => $request->produk_id, 
                'user_id'   => Auth::id(),
                'jumlah'    => $request->jumlah,
                'prioritas' => $request->prioritas,
                'keterangan'=> $request->keterangan,
                'status'    => 'Pending',
            ]);

            return redirect()->route('branch.tracking')->with('success', 'Gacor! Permintaan stok berhasil dikirim.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['msg' => 'Gagal kirim request: ' . $e->getMessage()]);
        }
    }

    public function tracking()
    {
        $userId = Auth::id();

        // REVISI: Eager Loading 'produk' harus dipastikan relasinya benar di Model
        $requests = StockRequest::with(['produk'])
                    ->where('user_id', $userId)
                    ->latest()
                    ->get();

        return view('pages.branch.tracking', compact('requests'));
    }

    public function dashboard()
    {
        $userId = Auth::id();
        
        $totalStok = BranchStock::where('user_id', $userId)->sum('stok_lokal');
        
        // Kita kirim kategori juga kalau sidebar butuh
        $categories = Category::all();
        
        $pendingRequests = StockRequest::where('user_id', $userId)
                            ->where('status', 'Pending')
                            ->count();

        $recentRequests = StockRequest::with('produk')
                            ->where('user_id', $userId)
                            ->latest()
                            ->take(5)
                            ->get();

        // Tambahkan categories di compact biar gak error di layout
        return view('pages.branch.dashboard', compact('totalStok', 'pendingRequests', 'recentRequests', 'categories'));
    }
}