@extends('app')

@section('breadcrumb', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-2xl font-bold mr-auto">Detail Pesanan #{{ str_pad($order->id, 7, '0', STR_PAD_LEFT) }}</h2>
    <a href="{{ route('pasien.order.history') }}"
    class="inline-flex items-center px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg text-sm transition-colors duration-200 shadow-sm hover:shadow">
     <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
     Kembali ke Riwayat
 </a>
</div>

<div class="intro-y box mt-8 p-8">
    <div class="space-y-8">
        <!-- Informasi Pesanan & Pengiriman -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-gray-50 rounded-xl p-6">
                <h4 class="font-bold text-gray-700 mb-4">Informasi Pesanan</h4>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Pesan</p>
                        <p class="font-medium">{{ $order->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="inline-block px-4 py-2 rounded-full text-white font-medium text-sm mt-2
                            @switch($order->status)
                                @case('diproses') bg-blue-500 @break
                                @case('dikirim') bg-purple-500 @break
                                @case('selesai') bg-green-500 @break
                                @default bg-yellow-500
                            @endswitch">
                            {{ ucwords(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-6">
                <h4 class="font-bold text-gray-700 mb-4">Informasi Pengiriman</h4>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Nama Penerima</p>
                        <p class="font-medium">{{ $order->nama_penerima }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Alamat</p>
                        <p class="font-medium">{{ $order->alamat }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">No. Telepon</p>
                        <p class="font-medium">{{ $order->no_telp }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Pesanan -->
        <div>
            <h4 class="font-bold text-gray-700 mb-4">Items Pesanan</h4>
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-white border border-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                                @if($item->obat->foto)
                                    <img src="{{ asset('storage/' . $item->obat->foto) }}" class="w-full h-full object-contain">
                                @else
                                    <i data-feather="package" class="w-8 h-8 text-gray-400"></i>
                                @endif
                            </div>
                            <div>
                                <h5 class="font-medium text-gray-900">{{ $item->obat->nama_obat }}</h5>
                                <p class="text-sm text-gray-500">Obat Demam & Sakit Kepala</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-900">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-500">× {{ $item->qty }} item</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Ringkasan Pembayaran -->
        <div class="intro-y box p-6 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl shadow-lg border border-blue-200">
            <h4 class="font-bold text-xl text-gray-800 mb-6 flex items-center">
                <i data-feather="credit-card" class="w-6 h-6 mr-3 text-blue-600"></i>
                Ringkasan Pembayaran
            </h4>
        
            <div class="space-y-4">
                <div class="flex justify-between items-center py-3">
                    <span class="text-gray-700 font-medium">Subtotal</span>
                    <span class="text-lg font-semibold text-gray-900">
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </span>
                </div>
        
                <div class="flex justify-between items-center py-3">
                    <span class="text-gray-700 font-medium">Biaya Pengiriman</span>
                    <span class="text-lg font-semibold text-gray-900">Rp 10.000</span>
                </div>
        
                <div class="flex justify-between items-center py-3">
                    <span class="text-gray-700 font-medium">Diskon</span>
                    <span class="text-lg font-semibold text-green-600">-Rp 5.000</span>
                </div>
        
                <!-- Garis Pemisah -->
                <div class="border-t-2 border-dashed border-blue-300 my-5"></div>
        
                <!-- Total Akhir -->
                <div class="flex justify-between items-center py-4 bg-white bg-opacity-60 rounded-xl px-5 -mx-5">
                    <span class="text-xl font-bold text-gray-800">Total Pembayaran</span>
                    <span class="text-3xl font-extrabold text-theme-1">
                        Rp {{ number_format($order->total + 10000 - 5000, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Timeline Status -->
        <div class="mt-8 bg-gray-50 rounded-xl p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                <div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i data-feather="clock" class="w-6 h-6 text-yellow-600"></i>
                    </div>
                    <p class="font-medium text-sm">Menunggu Bayar</p>
                </div>
                <div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i data-feather="settings" class="w-6 h-6 text-blue-600"></i>
                    </div>
                    <p class="font-medium text-sm">Diproses</p>
                </div>
                <div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i data-feather="truck" class="w-6 h-6 text-purple-600"></i>
                    </div>
                    <p class="font-medium text-sm">Dikirim</p>
                </div>
                <div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i data-feather="check-circle" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <p class="font-medium text-sm">Selesai</p>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-8 flex justify-end gap-4">
            <button onclick="window.print()" class="button bg-blue-600 text-white">
                <i data-feather="printer" class="w-4 h-4 mr-2"></i> Cetak Invoice
            </button>
        </div>
    </div>
</div>
@endsection