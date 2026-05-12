<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockRequest;
use Illuminate\Http\Request;

class StockRequestController extends Controller
{
    /**
     * Menampilkan semua permintaan stok dari berbagai cabang
     */
    public function index()
    {
        // Eager load produk (untuk nama barang) dan user (untuk nama cabang/admin cabang)
        $requests = StockRequest::with(['produk', 'user'])
                    ->latest()
                    ->paginate(10);

        return view('pages.admin.stock-request.index', compact('requests'));
    }

    /**
     * Menyetujui permintaan dan memperbarui status
     */
    public function approve(Request $request, $id)
    {
        $request->validate([
            'tgl_estimasi' => 'required|date|after_or_equal:today'
        ]);

        try {
            $stockRequest = StockRequest::findOrFail($id);
            $stockRequest->update([
                'status' => 'Dikirim',
                'tgl_estimasi' => $request->tgl_estimasi
            ]);

            return redirect()->back()->with('success', 'Permintaan disetujui dan status berubah jadi Dikirim.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['msg' => 'Gagal memproses: ' . $e->getMessage()]);
        }
    }

    /**
     * Menolak permintaan stok
     */
    public function reject($id)
    {
        try {
            $stockRequest = StockRequest::findOrFail($id);
            $stockRequest->update([
                'status' => 'Ditolak'
            ]);

            return redirect()->back()->with('success', 'Permintaan stok telah ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['msg' => 'Gagal menolak: ' . $e->getMessage()]);
        }
    }
}