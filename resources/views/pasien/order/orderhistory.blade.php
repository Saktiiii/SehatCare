@extends('app')
@section('breadcrumb')
    Order Obat
@endsection
@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Riwayat Pesanan</h1>
                    <p class="text-gray-600 mt-1">Lacak dan kelola semua pesanan Anda di satu tempat</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-history mr-2 text-blue-600"></i>
                        <span>{{ $orders->count() }} Pesanan</span>
                    </div>
                    <div class="relative">
                        <select class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option>Semua Status</option>
                            <option>Menunggu Pembayaran</option>
                            <option>Diproses</option>
                            <option>Dikirim</option>
                            <option>Selesai</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <!-- Total Orders -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Pesanan</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $orders->count() }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-bag text-blue-600"></i>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Menunggu Bayar</p>
                        <p class="text-2xl font-bold text-yellow-600 mt-1">
                            {{ $orders->where('status', 'pending')->count() }}
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                </div>
            </div>

            <!-- Processing Orders -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Diproses</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">
                            {{ $orders->where('status', 'diproses')->count() }}
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-cog text-blue-600"></i>
                    </div>
                </div>
            </div>

            <!-- Completed Orders -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Selesai</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">
                            {{ $orders->where('status', 'selesai')->count() }}
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        @if($orders->count() > 0)
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
                        <!-- Order Header -->
                        <div class="border-b border-gray-100 px-6 py-4">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                                <div class="flex items-center space-x-4">
                                    <div class="bg-blue-50 rounded-lg p-2">
                                        <i class="fas fa-receipt text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h3>
                                        <div class="flex items-center mt-1 space-x-4">
                                            <span class="text-sm text-gray-500">
                                                <i class="far fa-calendar mr-1"></i>
                                                {{ $order->created_at->format('d M Y, H:i') }}
                                            </span>
                                            <span class="text-sm text-gray-500">
                                                <i class="fas fa-box mr-1"></i>
                                                {{ $order->items->sum('qty') }} item
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-4">
                                    <!-- Status Badge -->
                                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                                        {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' :
                                           ($order->status == 'diproses' ? 'bg-blue-100 text-blue-800 border border-blue-200' :
                                           ($order->status == 'dikirim' ? 'bg-purple-100 text-purple-800 border border-purple-200' :
                                           'bg-green-100 text-green-800 border border-green-200')) }}">
                                        <i class="fas 
                                            {{ $order->status == 'pending' ? 'fa-clock' :
                                               ($order->status == 'diproses' ? 'fa-cog' :
                                               ($order->status == 'dikirim' ? 'fa-truck' :
                                               'fa-check-circle')) }} mr-1"></i>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    
                                    <!-- Total Amount -->
                                    <div class="text-right">
                                        <p class="text-xl font-bold text-blue-700">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500">Total Pembayaran</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="p-6">
                            <h4 class="font-medium text-gray-700 mb-4">Items dalam pesanan:</h4>
                            <div class="space-y-3">
                                @foreach($order->items as $item)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-white border border-gray-200 rounded-lg flex items-center justify-center">
                                                @if($item->obat->foto)
                                                    <img src="{{ asset('storage/'.$item->obat->foto) }}" 
                                                         alt="{{ $item->obat->nama_obat }}"
                                                         class="w-10 h-10 object-contain">
                                                @else
                                                    <i class="fas fa-pills text-blue-500"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <h5 class="font-medium text-gray-900">{{ $item->obat->nama_obat }}</h5>
                                                <p class="text-sm text-gray-500">{{ $item->obat->kategori->nama_kategori }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-medium text-gray-900">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                            <p class="text-sm text-gray-500">× {{ $item->qty }} item</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Order Actions -->
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                                        <i class="fas fa-info-circle"></i>
                                        <span>
                                            @if($order->status == 'pending')
                                                Pesanan akan segera disiapkan
                                            @elseif($order->status == 'diproses')
                                                Pesanan sedang diproses oleh Petugas
                                            @elseif($order->status == 'dikirim')
                                                Pesanan sedang dalam pengiriman
                                            @else
                                                Pesanan telah selesai
                                            @endif
                                        </span>
                                    </div>
                                    
                                    <div class="flex space-x-3">
                                       
                                        
                                        <a href="{{ route('pasien.order.show', $order->id) }}"
                                            class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors duration-200 shadow-sm hover:shadow-md">
                                             <i data-feather="eye" class="w-4 h-4 mr-2"></i>
                                             Detail
                                         </a>
                                        
                                        @if($order->status == 'selesai')
                                            <button onclick="reorder({{ $order->id }})"
                                                    class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm">
                                                <i class="fas fa-redo mr-2"></i>
                                                Pesan Lagi
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- <!-- Pagination -->
            @if($orders->hasPages())
                <div class="mt-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 px-6 py-4">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="text-gray-600 text-sm">
                                Menampilkan {{ $orders->firstItem() }} - {{ $orders->lastItem() }} dari {{ $orders->total() }} pesanan
                            </div>
                            <div class="flex items-center space-x-2">
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif --}}

        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-12 text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full flex items-center justify-center mx-auto mb-8">
                    <i class="fas fa-shopping-bag text-blue-500 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Belum Ada Pesanan</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Anda belum memiliki riwayat pesanan. Mulai pesan obat untuk menjaga kesehatan Anda.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('pasien.obat.index') }}"
                       class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold rounded-xl transition-all duration-300 hover:shadow-lg">
                        <i class="fas fa-pills mr-3"></i>
                        Beli Obat Sekarang
                    </a>
                    <a href="{{ route('chat.index') }}"
                       class="inline-flex items-center px-8 py-3 border-2 border-blue-600 text-blue-600 hover:bg-blue-50 font-bold rounded-xl transition-colors duration-200">
                        <i class="fas fa-comment-medical mr-3"></i>
                        Konsultasi Dokter
                    </a>
                </div>
            </div>
        @endif

        <!-- Order Timeline Info -->
        @if($orders->count() > 0)
            <div class="mt-8 bg-blue-50 border border-blue-100 rounded-xl p-6">
                <h4 class="font-bold text-blue-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Informasi Status Pesanan
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-700">Menunggu Bayar</p>
                        <p class="text-xs text-gray-500 mt-1">Upload bukti transfer</p>
                    </div>
                    <div class="text-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-cog text-blue-600"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-700">Diproses</p>
                        <p class="text-xs text-gray-500 mt-1">Apoteker menyiapkan</p>
                    </div>
                    <div class="text-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-truck text-purple-600"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-700">Dikirim</p>
                        <p class="text-xs text-gray-500 mt-1">Dalam pengiriman</p>
                    </div>
                    <div class="text-center">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-700">Selesai</p>
                        <p class="text-xs text-gray-500 mt-1">Pesanan diterima</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Customer Support -->
        <div class="mt-8 bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-8 md:py-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="text-white">
                        <h3 class="text-xl font-bold mb-2">Butuh Bantuan?</h3>
                        <p class="text-blue-100">
                            Ada masalah dengan pesanan Anda? Hubungi customer service kami.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="https://wa.me/6281234567890"
                           target="_blank"
                           class="inline-flex items-center justify-center px-6 py-3 bg-white hover:bg-gray-100 text-blue-700 font-bold rounded-xl transition-all duration-300 hover:scale-105 shadow-lg">
                            <i class="fab fa-whatsapp mr-3 text-lg"></i>
                            Chat WhatsApp
                        </a>
                        <a href="tel:02112345678"
                           class="inline-flex items-center justify-center px-6 py-3 bg-blue-800 hover:bg-blue-900 text-white font-bold rounded-xl transition-colors duration-200">
                            <i class="fas fa-phone mr-3"></i>
                            Telepon
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div id="orderDetailsModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto max-w-4xl">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">Detail Pesanan</h3>
                    <button onclick="closeOrderDetails()"
                            class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fas fa-times text-gray-500"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Content -->
            <div class="p-6">
                <div id="orderDetailsContent">
                    <!-- Content will be loaded via AJAX -->
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-spinner fa-spin text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-600">Memuat detail pesanan...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
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

/* Order status animations */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.7;
    }
}

.bg-yellow-100 {
    animation: pulse 2s infinite;
}

/* Modal animation */
@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

#orderDetailsModal > div {
    animation: modalSlideIn 0.3s ease-out;
}

/* Hover effects */
.hover-lift {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* Status badge glow */
.bg-yellow-100, .bg-blue-100, .bg-purple-100, .bg-green-100 {
    transition: all 0.3s ease;
}

.bg-yellow-100:hover {
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
}

.bg-blue-100:hover {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const statusBadges = document.querySelectorAll('[class*="bg-"]:not(.rounded-full)');
    statusBadges.forEach(badge => {
        badge.addEventListener('mouseenter', function() {
            const statusText = this.textContent.trim();
            // You could add a tooltip here if needed
        });
    });

    // Add hover effects to order cards
    const orderCards = document.querySelectorAll('.bg-white.rounded-xl');
    orderCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('hover-lift');
        });
        
        card.addEventListener('mouseleave', function() {
            this.classList.remove('hover-lift');
        });
    });

    // Filter functionality
    const statusFilter = document.querySelector('select');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const status = this.value;
            if (status === 'Semua Status') {
                // Show all orders
                orderCards.forEach(card => card.style.display = 'block');
            } else {
                // Filter orders
                orderCards.forEach(card => {
                    const statusBadge = card.querySelector('[class*="bg-"].rounded-full');
                    const statusText = statusBadge ? statusBadge.textContent.trim().toLowerCase() : '';
                    const filterText = status.toLowerCase();
                    
                    if (statusText.includes(filterText)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }
        });
    }
});

function orderDetails(orderId) {
    const modal = document.getElementById('orderDetailsModal');
    const content = document.getElementById('orderDetailsContent');
    
    // Show loading
    content.innerHTML = `
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-spinner fa-spin text-gray-400 text-2xl"></i>
            </div>
            <p class="text-gray-600">Memuat detail pesanan...</p>
        </div>
    `;
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Simulate API call (replace with actual AJAX)
    setTimeout(() => {
        content.innerHTML = `
            <div class="space-y-6">
                <!-- Order Summary -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-bold text-gray-700 mb-3">Informasi Pesanan</h4>
                            <div class="space-y-2">
                                <p class="text-sm"><span class="text-gray-500">ID Pesanan:</span> #${orderId.toString().padStart(6, '0')}</p>
                                <p class="text-sm"><span class="text-gray-500">Tanggal:</span> ${new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}</p>
                                <p class="text-sm"><span class="text-gray-500">Status:</span> <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Diproses</span></p>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-700 mb-3">Informasi Pengiriman</h4>
                            <div class="space-y-2">
                                <p class="text-sm"><span class="text-gray-500">Nama:</span> John Doe</p>
                                <p class="text-sm"><span class="text-gray-500">Alamat:</span> Jl. Contoh No. 123, Jakarta</p>
                                <p class="text-sm"><span class="text-gray-500">Telepon:</span> 0812-3456-7890</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Items List -->
                <div>
                    <h4 class="font-bold text-gray-700 mb-4">Items Pesanan</h4>
                    <div class="space-y-3">
                        <!-- Example item -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-white border border-gray-200 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-pills text-blue-500 text-xl"></i>
                                </div>
                                <div>
                                    <h5 class="font-medium text-gray-900">Paracetamol 500mg</h5>
                                    <p class="text-sm text-gray-500">Obat Demam & Sakit Kepala</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900">Rp 25.000</p>
                                <p class="text-sm text-gray-500">× 2 item</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Summary -->
                <div class="bg-blue-50 rounded-xl p-6">
                    <h4 class="font-bold text-gray-700 mb-4">Ringkasan Pembayaran</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">Rp 50.000</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Biaya Pengiriman</span>
                            <span class="font-medium">Rp 10.000</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Diskon</span>
                            <span class="font-medium text-green-600">-Rp 5.000</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3 mt-3">
                            <div class="flex justify-between">
                                <span class="font-bold text-gray-900">Total</span>
                                <span class="text-2xl font-bold text-blue-700">Rp 55.000</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <button onclick="closeOrderDetails()"
                            class="px-6 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium rounded-lg transition-colors">
                        Tutup
                    </button>
                    <button onclick="printOrder(${orderId})"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors flex items-center">
                        <i class="fas fa-print mr-2"></i>
                        Cetak Invoice
                    </button>
                </div>
            </div>
        `;
    }, 1000);
}

function closeOrderDetails() {
    const modal = document.getElementById('orderDetailsModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function cancelOrder(orderId) {
    if (confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
        // Simulate API call
        fetch(`/orders/${orderId}/cancel`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Pesanan berhasil dibatalkan', 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification('Gagal membatalkan pesanan', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan', 'error');
        });
    }
}

function reorder(orderId) {
    // Simulate reorder functionality
    showNotification('Item ditambahkan ke keranjang', 'success');
    
    // Redirect to cart or show modal
    setTimeout(() => {
        window.location.href = '';
    }, 1500);
}

function printOrder(orderId) {
    window.open(`/orders/${orderId}/invoice`, '_blank');
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-50 transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    notification.textContent = message;
    notification.style.transform = 'translateX(100%)';
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 10);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('orderDetailsModal');
    if (event.target === modal) {
        closeOrderDetails();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeOrderDetails();
    }
});
</script>
@endsection