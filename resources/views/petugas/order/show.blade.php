@extends('app')
@section('breadcrumb')
    Order Detail
@endsection
@section('content')
    <div class="intro-y box p-5 mt-5 lg:p-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-800">
                Detail Order #{{ $order->id }}
            </h2>
            <div class="mt-4 sm:mt-0">
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'proses' => 'bg-blue-100 text-blue-800',
                        'terkirim' => 'bg-indigo-100 text-indigo-800',
                        'selesai' => 'bg-green-100 text-green-800',
                        'batal' => 'bg-red-100 text-red-800',
                    ];
                    $colorClass = $statusColors[strtolower($order->status)] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <span class="px-4 py-2 rounded-full text-sm font-medium {{ $colorClass }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
            <!-- Informasi Penerima -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Penerima</h3>
                <div class="space-y-4 bg-gray-50 rounded-lg p-5">
                    <div>
                        <span class="text-sm text-gray-500">Nama</span>
                        <p class="font-medium text-gray-900">{{ $order->nama_penerima }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">No. Telepon</span>
                        <p class="font-medium text-gray-900">{{ $order->no_telp }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Alamat Pengiriman</span>
                        <p class="font-medium text-gray-900">{{ $order->alamat }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Metode Pembayaran</span>
                        <p class="font-medium text-gray-900 uppercase">{{ $order->payment_method }}</p>
                    </div>
                </div>
            </div>

            <!-- Bukti Pembayaran -->
            @if($order->bukti_bayar)
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Bukti Pembayaran</h3>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg overflow-hidden bg-gray-50">
                        <img src="{{ asset('storage/' . $order->bukti_bayar) }}" alt="Bukti Pembayaran"
                            class="w-full max-w-md mx-auto object-contain h-auto" style="max-height: 400px;">
                    </div>
                    <p class="text-center text-sm text-gray-500 mt-3">
                        Klik gambar untuk memperbesar
                    </p>
                </div>
            @endif
        </div>

        <!-- Daftar Obat yang Dipesan - Diperbaiki Responsif & Styling -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-6">Daftar Obat yang Dipesan</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($order->items as $item)
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow p-6">
                        <h4 class="font-semibold text-lg text-gray-900 mb-4">
                            {{ $item->obat->nama_obat }}
                        </h4>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jumlah</span>
                                <span class="font-medium">{{ $item->qty }} pcs</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Harga Satuan</span>
                                <span class="font-medium">Rp {{ number_format($item->obat->harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t pt-3 flex justify-between">
                                <span class="text-gray-700 font-medium">Subtotal</span>
                                <span class="font-bold text-theme-1 text-lg">
                                    Rp {{ number_format($item->qty * $item->obat->harga, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Total Pesanan - Lebih Elegan & Responsif -->
            <div class="mt-10 flex justify-end">
                <div class="bg-theme-1/10 border border-theme-1/30 rounded-xl px-8 py-6 w-full max-w-sm">
                    <div class="flex justify-between items-center">
                        <p class="text-xl font-semibold text-gray-700">Total Pesanan</p>
                        <p class="text-3xl font-bold text-theme-1">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi - Responsif & Rapi -->
        <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-end">
            {{-- Hanya muncul jika status sudah dibayar/diproses tapi belum dikirim dan belum selesai --}}
            @if(!in_array(strtolower($order->status), ['menunggu_pembayaran', 'pending', 'dikirim', 'selesai']))
                <form method="POST" action="{{ route('petugas.order.kirim', $order->id) }}" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit"
                        class="w-full sm:w-auto px-12 py-3 text-lg font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow transition">
                        Tandai sebagai Dikirim
                    </button>
                </form>
            @endif

            @if(strtolower($order->status) === 'dikirim')
                <form method="POST" action="{{ route('petugas.order.selesai', $order->id) }}" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit"
                        class="w-full sm:w-auto px-12 py-3 text-lg font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg shadow transition">
                        Tandai sebagai Selesai
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection