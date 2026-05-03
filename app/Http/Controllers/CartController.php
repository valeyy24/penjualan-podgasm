<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('pages.frontend.cart', compact('cart'));
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "nama" => $product->nama_barang,
                "quantity" => 1,
                "harga" => $product->harga_jual,
                "gambar" => $product->gambar
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    // 🔥 FITUR UPDATE JUMLAH (TAMBAH/KURANG)
    public function updateCart(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Keranjang berhasil diperbarui!');
        }
    }

    // 🔥 FITUR HAPUS PRODUK DARI KERANJANG
    public function removeFromCart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Produk berhasil dihapus!');
        }
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }
        return view('pages.frontend.checkout', compact('cart'));
    }

        public function processCheckout(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'email' => 'required|email',
            'no_telp' => 'required|numeric',
            'alamat_pengiriman' => 'required|string|min:10',
            'metode_pembayaran' => 'required',
        ]);

        $cart = session()->get('cart', []);

        try {
            DB::beginTransaction();

            $total = 0;
            foreach ($cart as $id => $item) {
                $total += $item['harga'] * $item['quantity'];
            }

            // 2. Simpan ke tabel orders (pastikan kolom ini sudah ada di migration)
            $order = Order::create([
                'user_id' => auth()->id(),
                'nama_penerima' => $request->nama_penerima, // Data baru
                'email' => $request->email,                 // Data baru
                'no_telp' => $request->no_telp,             // Data baru
                'invoice_number' => 'INV-' . strtoupper(uniqid()),
                'total_harga' => $total,
                'metode_pembayaran' => $request->metode_pembayaran, // Data baru
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'status' => 'pending'
            ]);

            // 3. Simpan ke tabel order_items
            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price_at_purchase' => $item['harga']
                ]);
                
                // Kurangi stok produk
                Product::find($id)->decrement('stok_aktual', $item['quantity']);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('home')->with('success', 'Pesanan berhasil dibuat! Silakan cek email atau menu pesanan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // --- FITUR WISHLIST ---
    public function wishlist()
    {
        $wishlist = session()->get('wishlist', []);
        return view('pages.frontend.wishlist', compact('wishlist'));
    }

    public function addToWishlist($id)
    {
        $product = Product::findOrFail($id);
        $wishlist = session()->get('wishlist', []);

        if (!isset($wishlist[$id])) {
            $wishlist[$id] = [
                "nama" => $product->nama_barang,
                "harga" => $product->harga_jual,
                "gambar" => $product->gambar
            ];
            session()->put('wishlist', $wishlist);
            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke Wishlist!');
        }
        return redirect()->back()->with('info', 'Produk sudah ada di Wishlist kamu.');
    }

    public function removeFromWishlist($id)
    {
        $wishlist = session()->get('wishlist');
        if (isset($wishlist[$id])) {
            unset($wishlist[$id]);
            session()->put('wishlist', $wishlist);
        }
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari Wishlist.');
    }
}