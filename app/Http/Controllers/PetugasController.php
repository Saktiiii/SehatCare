<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\Order;
use App\Models\Conversation;

class PetugasController extends Controller
{
    public function index()
{
    return view('petugas.dashboard', [
        'todayOrders'      => Order::whereDate('created_at', today())->count(),
        'waitingDelivery'  => Order::where('status', 'diproses')->count(),
        'lowStockCount'    => Obat::where('stok', '<', 10)->count(),
        'activeChats'      => Conversation::where('status', 'active')->count(),
        'latestOrders'     => Order::with('user')->latest()->take(10)->get(),
    ]);
}
}
