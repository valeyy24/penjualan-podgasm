<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function history()
    {
        // Mengambil pesanan milik user yang sedang login, diurutkan dari yang terbaru
        $orders = Order::with('items.product')
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->get();

        return view('pages.frontend.history', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product')
                    ->where('user_id', auth()->id())
                    ->findOrFail($id);

        return view('pages.frontend.order-detail', compact('order'));
    }
}