<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;

class OrderAdminController extends Controller
{
    
    /**
     * Daftar order masuk
     */
    public function index()
    {
        $orders = Order::with('items.obat','user')
            ->latest()
            ->get();

        return view('petugas.order.index', compact('orders'));
    }

    /**
     * Detail order
     */
    public function show(Order $order)
    {
        $order->load('items.obat','user');
        return view('petugas.order.show', compact('order'));
    }

    /**
     * Tandai dikirim
     */
    public function kirim(Order $order)
    {
        $order->update([
            'status' => 'dikirim'
        ]);

        return back()->with('success','Pesanan dikirim');
    }

    /**
     * Tandai selesai
     */
    public function selesai(Order $order)
    {
        $order->update([
            'status' => 'selesai'
        ]);

        return back()->with('success','Pesanan selesai');
    }
}
