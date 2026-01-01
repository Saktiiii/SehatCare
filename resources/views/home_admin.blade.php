@extends('app') 

@section('breadcrumb', 'Dashboard Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
                    <div class="flex items-center mt-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-3 animate-pulse"></div>
                        <p class="text-gray-600">Selamat datang kembali, <span class="font-semibold text-blue-600">{{ auth()->user()->name }}</span>!</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm rounded-full">
                        {{ now()->format('d F Y') }}
                    </span>
                    <span class="px-3 py-1 bg-green-100 text-green-700 text-sm rounded-full">
                        {{ now()->format('H:i') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Pengguna -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 transform transition-all duration-300 hover:scale-[1.02] hover:shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Pengguna</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalUsers) }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs text-gray-500">Semua role terdaftar</span>
                        </div>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="text-xs text-gray-500 flex items-center">
                        <i class="fas fa-chart-line mr-2 text-blue-500"></i>
                        <span>Data real-time</span>
                    </div>
                </div>
            </div>

            <!-- Pesanan Hari Ini -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 transform transition-all duration-300 hover:scale-[1.02] hover:shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Pesanan Hari Ini</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $todayOrders }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs text-gray-500">{{ now()->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-shopping-cart text-white text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="text-xs text-gray-500 flex items-center">
                        <i class="fas fa-bolt mr-2 text-yellow-500"></i>
                        <span>Aktif hari ini</span>
                    </div>
                </div>
            </div>

            <!-- Total Pendapatan Bulan Ini -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 transform transition-all duration-300 hover:scale-[1.02] hover:shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Pendapatan Bulan Ini</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs text-gray-500">{{ now()->format('F Y') }}</span>
                        </div>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-dollar-sign text-white text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="text-xs text-gray-500 flex items-center">
                        <i class="fas fa-trending-up mr-2 text-green-500"></i>
                        <span>Akumulasi bulanan</span>
                    </div>
                </div>
            </div>

            <!-- Obat Hampir Habis -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 transform transition-all duration-300 hover:scale-[1.02] hover:shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Obat Hampir Habis</p>
                        <p class="text-3xl font-bold text-red-600 mt-2">{{ $lowStockCount }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs text-gray-500">Stok < 10 unit</span>
                        </div>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-exclamation-triangle text-white text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="text-xs text-gray-500 flex items-center">
                        <i class="fas fa-box mr-2 text-red-500"></i>
                        <span>Perlu restok</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Analytics Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Main Chart -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Grafik Pesanan {{ now()->year }}</h3>
                            <p class="text-gray-600 mt-1">Perkembangan pesanan per bulan</p>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg font-medium">
                                Total: {{ $orderChart['total'] }} pesanan
                            </span>
                        </div>
                    </div>
                    <div class="h-80">
                        <canvas id="orderChart" class="w-full"></canvas>
                    </div>
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="text-center">
                                <p class="text-sm text-gray-500">Rata-rata Bulanan</p>
                                <p class="text-lg font-bold text-gray-900">{{ round($orderChart['total'] / 12) }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-500">Bulan Tertinggi</p>
                                <p class="text-lg font-bold text-gray-900">{{ max($orderChart['counts']) }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-500">Bulan Terendah</p>
                                <p class="text-lg font-bold text-gray-900">{{ min($orderChart['counts']) }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-500">Pertumbuhan</p>
                                <p class="text-lg font-bold text-green-600">+12.5%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="space-y-6">
                <!-- Status Pesanan -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Status Pesanan</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-xl hover:bg-yellow-100 transition-colors">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3 animate-pulse"></div>
                                <span class="font-medium text-gray-700">Menunggu Pembayaran</span>
                            </div>
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full font-bold">
                                {{ $statusCounts['menunggu_pembayaran'] ?? 0 }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                                <span class="font-medium text-gray-700">Diproses</span>
                            </div>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-bold">
                                {{ $statusCounts['diproses'] ?? 0 }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                                <span class="font-medium text-gray-700">Dikirim</span>
                            </div>
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full font-bold">
                                {{ $statusCounts['dikirim'] ?? 0 }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl hover:bg-green-100 transition-colors">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                <span class="font-medium text-gray-700">Selesai</span>
                            </div>
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full font-bold">
                                {{ $statusCounts['selesai'] ?? 0 }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Chat Konsultasi Aktif -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl  font-bold  text-gray-900">Chat Konsultasi</h3>
                        <div class="w-10 h-10 bg-gray-700 bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-comments"></i>
                        </div>
                    </div>
                    <div class="text-center mb-4">
                        <p class="text-5xl font-bold text-gray-700">{{ $activeChats }}</p>
                        <p class="text-blue-500 mt-2">Sesi aktif</p>
                    </div>
                    <div class="bg-blue-700 bg-opacity-20 rounded-lg p-4">
                        <p class="text-sm text-white">
                            <i class="fas fa-clock mr-2"></i>
                            Menunggu balasan dokter
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Pesanan Terbaru</h3>
                        <p class="text-gray-600 text-sm mt-1">5 pesanan terakhir yang masuk</p>
                    </div>
                    <a href="{{ route('petugas.order.index') }}"
                       class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg transition-all duration-300 hover:shadow-lg">
                        <i class="fas fa-list mr-2"></i>
                        Lihat Semua Pesanan
                    </a>
                </div>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                No. Pesanan
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Pelanggan
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Total
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($latestOrders as $order)
                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-receipt text-blue-600 text-sm"></i>
                                    </div>
                                    <span class="font-bold text-gray-900">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-gray-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                                        <p class="text-xs text-gray-500">ID: {{ $order->user_id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-gray-900 font-medium">{{ $order->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-lg font-bold text-blue-700">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusConfig = [
                                        'menunggu_pembayaran' => ['color' => 'bg-yellow-100 text-yellow-800', 'icon' => 'clock'],
                                        'diproses' => ['color' => 'bg-blue-100 text-blue-800', 'icon' => 'cog'],
                                        'dikirim' => ['color' => 'bg-purple-100 text-purple-800', 'icon' => 'truck'],
                                        'selesai' => ['color' => 'bg-green-100 text-green-800', 'icon' => 'check-circle'],
                                    ];
                                    $config = $statusConfig[$order->status] ?? ['color' => 'bg-gray-100 text-gray-800', 'icon' => 'question-circle'];
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $config['color'] }}">
                                    <i class="fas fa-{{ $config['icon'] }} mr-2"></i>
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('petugas.order.show', $order->id) }}"
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition-colors duration-200">
                                    <i class="fas fa-eye mr-2 text-xs"></i>
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">Belum ada pesanan</p>
                                    <p class="text-sm mt-2">Tidak ada pesanan yang masuk saat ini</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            @if($latestOrders->count() > 0)
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                            <span>Menampilkan {{ min(5, $latestOrders->count()) }} pesanan terbaru</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-green-600 font-medium">
                                <i class="fas fa-chart-line mr-1"></i>
                                {{ $todayOrders }} pesanan hari ini
                            </span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="mt-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Aksi Cepat</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('obat.index') }}"
                   class="group bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-lg hover:border-blue-300 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors">
                            <i class="fas fa-pills text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Kelola Obat</p>
                            <p class="text-sm text-gray-500">Tambah/edit stok obat</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('petugas.order.index') }}"
                   class="group bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-lg hover:border-green-300 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-200 transition-colors">
                            <i class="fas fa-shipping-fast text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Proses Pesanan</p>
                            <p class="text-sm text-gray-500">Update status pengiriman</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('user.index') }}"
                   class="group bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-lg hover:border-purple-300 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-200 transition-colors">
                            <i class="fas fa-user-cog text-purple-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Kelola User</p>
                            <p class="text-sm text-gray-500">Atur role dan akses</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('nakes.dashboard') }}"
                   class="group bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-lg hover:border-yellow-300 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-yellow-200 transition-colors">
                            <i class="fas fa-comment-medical text-yellow-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Monitor Chat</p>
                            <p class="text-sm text-gray-500">Pantau konsultasi pasien</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom animations */
@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.bg-gradient-animated {
    background: linear-gradient(270deg, #3b82f6, #8b5cf6, #10b981, #f59e0b);
    background-size: 800% 800%;
    animation: gradientShift 15s ease infinite;
}

/* Smooth scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: #3b82f6;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #2563eb;
}

/* Hover effects */
.transform-hover {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.transform-hover:hover {
    transform: translateY(-4px);
}

/* Pulse animation for urgent items */
@keyframes pulse-gentle {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.8;
    }
}

.animate-pulse-gentle {
    animation: pulse-gentle 2s infinite;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize Chart
    const ctx = document.getElementById('orderChart').getContext('2d');
    
    // Gradient for chart
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.3)');
    gradient.addColorStop(1, 'rgba(79, 70, 229, 0.05)');
    
    const orderChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($orderChart['months']) !!},
            datasets: [{
                label: 'Jumlah Pesanan',
                data: {!! json_encode($orderChart['counts']) !!},
                borderColor: '#4f46e5',
                backgroundColor: gradient,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#4f46e5',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 10,
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#4f46e5',
                    borderWidth: 1,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return `Pesanan: ${context.parsed.y}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        stepSize: 1,
                        font: {
                            family: "'Inter', sans-serif"
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: "'Inter', sans-serif"
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animations: {
                tension: {
                    duration: 1000,
                    easing: 'linear'
                }
            }
        }
    });

    // Real-time updates simulation
    function simulateRealTimeUpdates() {
        setTimeout(() => {
            const pulseElements = document.querySelectorAll('.animate-pulse');
            pulseElements.forEach(el => {
                el.classList.remove('animate-pulse');
                void el.offsetWidth; // Trigger reflow
                el.classList.add('animate-pulse');
            });
        }, 5000);
    }
    
    // Start real-time simulation
    simulateRealTimeUpdates();
    setInterval(simulateRealTimeUpdates, 30000);

    // Add hover effects to cards
    const statCards = document.querySelectorAll('.transform');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('shadow-xl');
        });
        
        card.addEventListener('mouseleave', function() {
            this.classList.remove('shadow-xl');
        });
    });

    // Update time every minute
    function updateCurrentTime() {
        const now = new Date();
        const timeElement = document.querySelector('.text-green-700:last-child');
        if (timeElement) {
            timeElement.textContent = now.toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
        }
    }
    
    updateCurrentTime();
    setInterval(updateCurrentTime, 60000);
});
</script>
@endsection