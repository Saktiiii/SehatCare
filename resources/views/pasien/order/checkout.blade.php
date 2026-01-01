@extends('app')
@section('breadcrumb')
    Order Obat
@endsection
@section('content')
<div class="max-w-5xl mx-auto mt-10">

    <h2 class="text-2xl font-bold mb-6">Checkout Pesanan</h2>

    <form action="{{ route('pasien.order.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- DATA PENERIMA -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="form-label">Nama Penerima</label>
                <input type="text" name="nama_penerima"
                       class="input w-full border mt-2"
                       required>
            </div>

            <div>
                <label class="form-label">No. Telepon</label>
                <input type="text" name="no_telp"
                       class="input w-full border mt-2"
                       required>
            </div>

            <div class="md:col-span-2">
                <label class="form-label">Alamat Lengkap</label>
                <textarea name="alamat"
                          class="input w-full border mt-2"
                          rows="3"
                          required></textarea>
            </div>
        </div>

     <!-- METODE PEMBAYARAN -->
<div class="box p-6 mb-6">
    <h3 class="font-semibold mb-3">Metode Pembayaran</h3>

    <select name="payment_method"
            class="input w-full border"
            required
            id="paymentMethod">
        <option value="">-- Pilih Metode --</option>
        <option value="cod">COD (Bayar di Tempat)</option>
        <option value="transfer">Transfer Bank</option>
    </select>

    <!-- REKENING -->
    <div id="rekeningBox" class="hidden mt-4 p-4 bg-gray-100 rounded">
        <p class="font-semibold">Transfer ke rekening:</p>
        <p>BCA 123456789</p>
        <p>a.n Apotek Sehat</p>

        <!-- UPLOAD BUKTI -->
        <div class="mt-4">
            <label class="form-label">Upload Bukti Pembayaran</label>
            <input type="file"
                   name="bukti_bayar"
                   class="input w-full border mt-2"
                   accept="image/*">
            <small class="text-gray-500">
                * Wajib diisi jika memilih Transfer
            </small>
        </div>
    </div>
</div>


        <!-- DAFTAR OBAT -->
        <div class="box p-6">
            <h3 class="font-semibold mb-4">Detail Pesanan</h3>

            <table class="table table-bordered w-full">
                <thead>
                    <tr>
                        <th>Obat</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp

                    @foreach($items as $i => $item)
                        @php
                            $subtotal = $item['harga'] * $item['qty'];
                            $total += $subtotal;
                        @endphp

                        <tr>
                            <td>{{ $item['nama'] }}</td>
                            <td>Rp {{ number_format($item['harga'],0,',','.') }}</td>
                            <td>{{ $item['qty'] }}</td>
                            <td>Rp {{ number_format($subtotal,0,',','.') }}</td>
                        </tr>

                        <!-- hidden -->
                        <input type="hidden" name="items[{{ $i }}][obat_id]" value="{{ $item['obat_id'] }}">
                        <input type="hidden" name="items[{{ $i }}][qty]" value="{{ $item['qty'] }}">
                        <input type="hidden" name="items[{{ $i }}][harga]" value="{{ $item['harga'] }}">
                    @endforeach
                </tbody>
            </table>

            <div class="text-right mt-4 text-lg font-bold">
                Total: Rp {{ number_format($total,0,',','.') }}
            </div>
        </div>

        <!-- BUTTON -->
        <div class="flex justify-end mt-6">
            <button type="submit"
                    class="button bg-theme-1 text-white px-8">
                Pesan Sekarang
            </button>
        </div>

    </form>
</div>
@if(session('show_upload_modal'))
<div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-lg p-6">
        <h3 class="text-lg font-bold mb-4">
            Upload Bukti Pembayaran
        </h3>

        <p class="text-sm mb-4 text-gray-600">
            Silakan transfer ke:
            <br><b>BCA 123456789</b>
            <br>a.n Apotek Sehat
        </p>

        <form action="{{ route('pasien.order.upload', session('order_id')) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <input type="file"
                   name="bukti_bayar"
                   class="input w-full border mb-4"
                   required>

            <div class="flex justify-end">
                <button type="submit"
                        class="button bg-theme-1 text-white px-6">
                    Upload Bukti
                </button>
            </div>
        </form>
    </div>
</div>
@endif


<script>
document.getElementById('paymentMethod').addEventListener('change', function () {
    document.getElementById('rekeningBox')
        .classList.toggle('hidden', this.value !== 'transfer');
});
</script>
@endsection
