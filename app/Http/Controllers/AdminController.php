<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\User;
use App\Models\Order;
use App\Models\Obat;

class AdminController extends Controller
{
    public function index()
    {
        return view('home_admin', [
            'totalUsers' => User::count(),
            'todayOrders' => Order::whereDate('created_at', today())->count(),
            'monthlyRevenue' => Order::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('status', 'selesai')
                ->sum('total'),
            'lowStockCount' => Obat::where('stok', '<', 10)->count(),
            'activeChats' => Conversation::where('status', 'active')->count(),

            // Status counts
            'statusCounts' => Order::selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status'),

            // Grafik pesanan 12 bulan
            'orderChart' => $this->getOrderChartData(),

            // Pesanan terbaru
            'latestOrders' => Order::with('user')->latest()->take(10)->get()
        ]);
    }

    private function getOrderChartData()
    {
        $year = now()->year;

        // Ambil data pesanan per bulan di tahun ini
        $data = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $counts = [];

        $total = 0;
        for ($i = 1; $i <= 12; $i++) {
            $count = $data[$i] ?? 0;
            $counts[] = $count;
            $total += $count;
        }

        return [
            'months' => $months,
            'counts' => $counts,
            'total' => $total,
            'year' => $year
        ];
    }
}
