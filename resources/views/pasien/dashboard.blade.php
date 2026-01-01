@extends('app')

@section('breadcrumb', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Welcome -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Selamat Datang, <span class="text-blue-600">{{ auth()->user()->name }}</span>!</h1>
                    <p class="text-gray-600 mt-2">Kelola kesehatan Anda dengan mudah di satu platform</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="px-4 py-2 bg-blue-100 text-blue-700 text-sm font-medium rounded-full">
                        <i class="fas fa-user-circle mr-2"></i>Pasien
                    </span>
                    <span class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-full">
                        {{ now()->format('d F Y') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-8">
            <!-- Cari Obat Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mr-4 shadow-md">
                        <i class="fas fa-search text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Cari Obat</h3>
                        <p class="text-gray-600 text-sm mt-1">Temukan obat yang Anda butuhkan</p>
                    </div>
                </div>
                
                <form action="{{ route('pasien.obat.index') }}" method="GET" class="space-y-4">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-pills text-gray-400"></i>
                        </div>
                        <input type="text" 
                               name="search" 
                               class="pl-12 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               placeholder="Nama obat, gejala, atau kategori..."
                               required>
                    </div>
                    <button type="submit" 
                            class="w-full bg-blue-700 hover:to-blue-800 text-white font-medium py-3 px-6 rounded-xl transition-all duration-300 hover:shadow-lg flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>
                        Cari Obat Sekarang
                    </button>
                </form>
                
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                        <span>Konsultasi dulu dengan dokter jika ragu</span>
                    </div>
                </div>
            </div>

            <!-- Status Pesanan Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mr-4 shadow-md">
                            <i class="fas fa-shopping-bag text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Pesanan Saya</h3>
                            <p class="text-gray-600 text-sm mt-1">Lacak status pesanan Anda</p>
                        </div>
                    </div>
                    <a href="{{ route('pasien.order.history') }}" 
                       class="text-blue-600 hover:text-blue-800 font-medium flex items-center transition-colors">
                        Lihat semua
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <div class="text-center mb-6">
                    <p class="text-5xl font-bold text-gray-900">{{ $myOrdersCount }}</p>
                    <p class="text-gray-600 mt-2">Total Pesanan</p>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-4">
                    @if($latestOrder)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">Pesanan Terbaru</p>
                                <p class="text-sm text-gray-600 mt-1">#{{ $latestOrder->id }}</p>
                            </div>
                            <div class="text-right">
                                @php
                                    $statusColors = [
                                        'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-800',
                                        'diproses' => 'bg-blue-100 text-blue-800',
                                        'dikirim' => 'bg-purple-100 text-purple-800',
                                        'selesai' => 'bg-green-100 text-green-800',
                                    ];
                                    $statusColor = $statusColors[$latestOrder->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                                    {{ ucfirst(str_replace('_', ' ', $latestOrder->status)) }}
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox text-gray-400 text-2xl mb-3"></i>
                            <p class="text-gray-600">Belum ada pesanan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Bottom Section Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Chat Konsultasi Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 text-white overflow-hidden relative">
                <!-- Background Pattern -->
                <div class="absolute top-0 right-0 w-40 h-40 bg-blue-100 bg-opacity-10 rounded-full -translate-y-20 translate-x-20"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-blue-100 bg-opacity-10 rounded-full translate-y-16 -translate-x-16"></div>
                
                <div class="relative">
                    <div class="flex items-center mb-8">
                        <div class="w-16 h-16 bg-blue-500 bg-opacity-20 rounded-2xl flex items-center justify-center mr-6">
                            <i class="fas fa-comment-medical text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl text-blue-600 font-bold mb-2">Konsultasi dengan Dokter</h3>
                            <p class="text-blue-200">Tanyakan keluhan kesehatan Anda secara gratis</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8">
                        <a href="{{ route('chat.create') }}" 
                           class="bg-white hover:bg-gray-100 text-blue-700 font-bold py-4 px-6 rounded-xl transition-all duration-300 hover:scale-[1.02] flex items-center justify-center shadow-lg">
                            <i class="fas fa-plus-circle mr-3 text-lg"></i>
                            Mulai Konsultasi Baru
                        </a>
                        <a href="{{ route('chat.history') }}" 
                           class="bg-blue-600 hover:bg-opacity-30 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 hover:scale-[1.02] flex items-center justify-center border text-white border-white border-opacity-30">
                            <i class="fas fa-history mr-3"></i>
                            Lihat Riwayat Chat
                        </a>
                    </div>
                    
                    <div class="mt-8 pt-6 border-t border-white border-opacity-20">
                        <div class="flex items-center text-blue-200 text-sm">
                            <i class="fas fa-shield-alt mr-2"></i>
                            <span>Konsultasi aman dan terjaga kerahasiaannya</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Pesanan Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mr-4 shadow-md">
                            <i class="fas fa-receipt text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Riwayat Pesanan Terbaru</h3>
                            <p class="text-gray-600 text-sm mt-1">5 pesanan terakhir Anda</p>
                        </div>
                    </div>
                    <a href="{{ route('pasien.order.history') }}" 
                       class="text-blue-600 hover:text-blue-800 font-medium flex items-center text-sm transition-colors">
                        Selengkapnya
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <div class="space-y-3 max-h-80 overflow-y-auto pr-2">
                    @forelse($myLatestOrders as $order)
                        <div class="group bg-gray-50 hover:bg-blue-50 rounded-xl p-4 transition-all duration-300 hover:scale-[1.01]">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-white border border-gray-200 rounded-lg flex items-center justify-center mr-4 group-hover:bg-blue-100 transition-colors">
                                        <i class="fas fa-box text-gray-600 group-hover:text-blue-600"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                                        <div class="text-sm text-gray-600 mt-1">{{ $order->created_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                                    @php
                                        $statusColors = [
                                            'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-800',
                                            'diproses' => 'bg-blue-100 text-blue-800',
                                            'dikirim' => 'bg-purple-100 text-purple-800',
                                            'selesai' => 'bg-green-100 text-green-800',
                                        ];
                                        $statusColor = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <div class="text-xs mt-1">
                                        <span class="px-2 py-1 rounded-full font-medium {{ $statusColor }}">
                                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-shopping-bag text-gray-400 text-xl"></i>
                            </div>
                            <h4 class="text-lg font-medium text-gray-700 mb-2">Belum Ada Pesanan</h4>
                            <p class="text-gray-600 mb-6">Mulai belanja obat untuk melihat riwayat di sini</p>
                            <a href="{{ route('pasien.obat.index') }}" 
                               class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                <i class="fas fa-pills mr-2"></i>
                                Beli Obat Sekarang
                            </a>
                        </div>
                    @endforelse
                </div>
                
                @if($myLatestOrders->count() > 0)
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-2"></i>
                                <span>Diperbarui: {{ now()->format('H:i') }}</span>
                            </div>
                            <span>{{ $myLatestOrders->count() }} dari {{ $myOrdersCount }} pesanan</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Tips Section -->
        <div class="mt-8 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-2xl border border-blue-100 p-6">
            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-lightbulb text-yellow-500 mr-3 text-xl"></i>
                Tips Kesehatan
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-pills text-blue-600 text-sm"></i>
                        </div>
                        <p class="font-medium text-gray-900">Gunakan Obat Sesuai Anjuran</p>
                    </div>
                    <p class="text-sm text-gray-600">Ikuti dosis dan petunjuk penggunaan yang diberikan dokter atau apoteker</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-comment-medical text-green-600 text-sm"></i>
                        </div>
                        <p class="font-medium text-gray-900">Konsultasi Sebelum Membeli</p>
                    </div>
                    <p class="text-sm text-gray-600">Pastikan obat yang dibeli sesuai dengan kondisi kesehatan Anda</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-history text-purple-600 text-sm"></i>
                        </div>
                        <p class="font-medium text-gray-900">Simpan Riwayat Kesehatan</p>
                    </div>
                    <p class="text-sm text-gray-600">Catat riwayat pengobatan untuk konsultasi yang lebih efektif</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom scrollbar */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Smooth transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
}

/* Hover effects */
.group:hover .group-hover\:bg-blue-100 {
    background-color: #dbeafe;
}

.group:hover .group-hover\:text-blue-600 {
    color: #2563eb;
}

/* Gradient animation */
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update current time
    function updateCurrentTime() {
        const now = new Date();
        const timeElements = document.querySelectorAll('.text-gray-500:has(.fa-clock) span');
        timeElements.forEach(el => {
            el.textContent = now.toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
        });
    }
    
    updateCurrentTime();
    setInterval(updateCurrentTime, 60000);
    
    // Add hover effects to cards
    const cards = document.querySelectorAll('.bg-white.rounded-2xl');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('shadow-xl');
        });
        
        card.addEventListener('mouseleave', function() {
            this.classList.remove('shadow-xl');
        });
    });
    
    // Auto-focus search input
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        setTimeout(() => {
            searchInput.focus();
        }, 500);
    }
    
    // Smooth scroll for order history
    const orderHistory = document.querySelector('.overflow-y-auto');
    if (orderHistory && orderHistory.scrollHeight > orderHistory.clientHeight) {
        orderHistory.classList.add('pr-2');
    }
});
</script>
@endsection