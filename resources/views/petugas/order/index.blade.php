@extends('app')
@section('breadcrumb')
    Order Obat
@endsection
@section('content')
<div class="container mx-auto px-4 py-6">

    <!-- Summary cards atas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white shadow rounded-lg p-5 flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-shopping-cart text-3xl text-blue-500"></i>
            </div>
            <div class="ml-4">
                <h4 class="text-lg font-semibold text-gray-700">Total Pesanan</h4>
                <p class="text-2xl font-bold text-gray-900">{{ $orders->count() }}</p>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-5 flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-truck text-3xl text-green-500"></i>
            </div>
            <div class="ml-4">
                <h4 class="text-lg font-semibold text-gray-700">Pesanan Terkirim</h4>
                <p class="text-2xl font-bold text-gray-900">{{ $orders->where('status', 'selesai')->count() }}</p>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-5 flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-clock text-3xl text-yellow-500"></i>
            </div>
            <div class="ml-4">
                <h4 class="text-lg font-semibold text-gray-700">Pesanan Pending</h4>
                <p class="text-2xl font-bold text-gray-900">{{ $orders->where('status', 'pending')->count() }}</p>
            </div>
        </div>
       
    </div>

    <!-- Tabel Daftar Order -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Daftar Order Masuk</h2>

   <!-- TABLE ORDERS -->
<div class="intro-y datatable-wrapper box p-5 mt-5">
    <table class="table table-report table-report--bordered display datatable w-full">
        <thead>
            <tr>
                <th class="border-b">ID</th>
                <th class="border-b">Pasien</th>
                <th class="border-b text-right">Total</th>
                <th class="border-b">Pembayaran</th>
                <th class="border-b text-center">Status</th>
                <th class="border-b text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($orders as $o)
            <tr>
                <td class="border-b">
                    <div class="font-medium">#{{ $o->id }}</div>
                </td>

                <td class="border-b">
                    <div class="font-medium">{{ $o->nama_penerima }}</div>
                </td>

                <td class="border-b text-right">
                    <div class="font-semibold">
                        Rp {{ number_format($o->total, 0, ',', '.') }}
                    </div>
                </td>

                <td class="border-b">
                    <div class="uppercase">{{ $o->payment_method }}</div>
                </td>

                <td class="border-b text-center">
                    @php
                        $statusColors = [
                            'Terkirim' => 'bg-green-100 text-green-800',
                            'Pending'  => 'bg-yellow-100 text-yellow-800',
                            'Batal'    => 'bg-red-100 text-red-800',
                            'Proses'   => 'bg-blue-100 text-blue-800',
                        ];
                        $colorClass = $statusColors[$o->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $colorClass }}">
                        {{ $o->status }}
                    </span>
                </td>

                <td class="border-b text-center">
                    <div class="flex justify-center items-center">
                        <a href="{{ route('petugas.order.show', $o->id) }}"
                           class="text-theme-1 font-medium hover:underline">
                            Detail
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
    </div>

</div>
@endsection
