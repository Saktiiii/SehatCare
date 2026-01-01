@extends('app')

@section('breadcrumb', 'Dashboard Petugas')

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-2xl font-bold mr-auto">Dashboard Petugas</h2>
    <div class="text-gray-600">Selamat datang kembali, {{ auth()->user()->name }}!</div>
</div>

<!-- Statistik Utama -->
<div class="grid grid-cols-12 gap-6 mt-8">
    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
        <div class="intro-y box p-5 zoom-in">
            <div class="flex items-center">
                <div class="w-12 h-12 flex-none rounded-lg bg-theme-9 text-white flex items-center justify-center">
                    <i data-feather="shopping-cart" class="w-6 h-6"></i>
                </div>
                <div class="ml-4 mr-auto">
                    <div class="text-base font-medium">Pesanan Hari Ini</div>
                    <div class="text-2xl font-bold mt-1">{{ $todayOrders }}</div>
                    <div class="text-gray-600 text-xs mt-1">{{ now()->format('d M Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
        <div class="intro-y box p-5 zoom-in">
            <div class="flex items-center">
                <div class="w-12 h-12 flex-none rounded-lg bg-theme-12 text-white flex items-center justify-center">
                    <i data-feather="truck" class="w-6 h-6"></i>
                </div>
                <div class="ml-4 mr-auto">
                    <div class="text-base font-medium">Menunggu Dikirim</div>
                    <div class="text-2xl font-bold mt-1">{{ $waitingDelivery }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
        <div class="intro-y box p-5 zoom-in">
            <div class="flex items-center">
                <div class="w-12 h-12 flex-none rounded-lg bg-theme-11 text-white flex items-center justify-center">
                    <i data-feather="package" class="w-6 h-6"></i>
                </div>
                <div class="ml-4 mr-auto">
                    <div class="text-base font-medium">Obat Hampir Habis</div>
                    <div class="text-2xl font-bold mt-1">{{ $lowStockCount }}</div>
                    <div class="text-gray-600 text-xs mt-1">Stok < 10</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
        <div class="intro-y box p-5 zoom-in">
            <div class="flex items-center">
                <div class="w-12 h-12 flex-none rounded-lg bg-theme-6 text-white flex items-center justify-center">
                    <i data-feather="message-circle" class="w-6 h-6"></i>
                </div>
                <div class="ml-4 mr-auto">
                    <div class="text-base font-medium">Chat Konsultasi Aktif</div>
                    <div class="text-2xl font-bold mt-1">{{ $activeChats }}</div>
                    <div class="text-gray-600 text-xs mt-1">Menunggu balasan</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pesanan Terbaru & Chat -->
<div class="grid grid-cols-12 gap-6 mt-8">
    <!-- Tabel Pesanan Terbaru -->
    <div class="col-span-12 lg:col-span-8">
        <div class="intro-y box">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
                <h2 class="text-lg font-medium mr-auto">Pesanan Terbaru</h2>
                <a href="{{ route('petugas.order.index') }}" class="button button--sm bg-theme-1 text-white mt-3 sm:mt-0">Lihat Semua</a>
            </div>
            <div class="p-5">
                <div class="overflow-x-auto">
                    <table class="table table-report">
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestOrders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center {{ $order->status_color ?? 'text-gray-600' }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-600">Belum ada pesanan baru</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Konsultasi Aktif -->
    <div class="col-span-12 lg:col-span-4">
        <div class="intro-y box p-6 bg-gradient-to-br from-indigo-600 to-purple-700 text-white rounded-2xl shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold">Chat Konsultasi</h3>
                <i data-feather="message-circle" class="w-8 h-8 opacity-80"></i>
            </div>
            <div class="text-center mb-6">
                <div class="text-5xl font-extrabold">{{ $activeChats }}</div>
                <div class="text-blue-100 mt-3 text-lg">Sesi aktif</div>
            </div>
            <a href="{{ route('chat.history') }}" class="block bg-white bg-opacity-20 hover:bg-opacity-30 rounded-xl px-5 py-4 text-center transition">
                <i data-feather="arrow-right" class="w-5 h-5 inline mr-2"></i>
                Lihat & Balas Chat
            </a>
        </div>
    </div>
</div>
@endsection