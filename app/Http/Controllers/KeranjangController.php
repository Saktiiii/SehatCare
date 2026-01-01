<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class KeranjangController extends Controller
{
    /**
     * Halaman checkout
     */
    public function checkout(Request $request)
    {
        $items = $request->items ?? [];

        if (empty($items)) {
            return redirect()
                ->route('pasien.obat.index')
                ->with('error', 'Tidak ada obat yang dipilih');
        }

        return view('pasien.order.checkout', compact('items'));
    }

    /**
     * Proses order
     */
    public function process(Request $request)
    {
        $request->validate([
            'nama_penerima' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'payment_method' => 'required|in:cod,transfer',
            'items' => 'required|array',
            'bukti_bayar' => $request->payment_method === 'transfer'
                ? 'required|image|mimes:jpg,jpeg,png|max:2048'
                : 'nullable'
        ]);

        DB::transaction(function () use ($request) {

            $total = 0;

            foreach ($request->items as $item) {
                $obat = Obat::findOrFail($item['obat_id']);

                if ($item['qty'] > $obat->stok) {
                    throw new \Exception(
                        'Stok obat ' . $obat->nama_obat . ' tidak mencukupi'
                    );
                }

                $total += $item['qty'] * $item['harga'];
            }

            // 📸 simpan bukti bayar jika transfer
            $buktiPath = null;
            if ($request->payment_method === 'transfer') {
                $buktiPath = $request->file('bukti_bayar')
                    ->store('bukti-bayar', 'public');

            }

            // 🧾 simpan order
            $order = Order::create([
                'user_id' => auth()->id(),
                'nama_penerima' => $request->nama_penerima,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'bukti_bayar' => $buktiPath,
                'status' => $request->payment_method === 'cod'
                    ? 'pending'
                    : 'diproses'
            ]);

            // 📦 simpan item + kurangi stok
            foreach ($request->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'obat_id' => $item['obat_id'],
                    'qty' => $item['qty'],
                    'harga' => $item['harga']
                ]);

                Obat::where('id', $item['obat_id'])
                    ->decrement('stok', $item['qty']);
            }
        });

        return redirect()
            ->route('pasien.order.history')
            ->with('success', 'Pesanan berhasil dibuat');
    }


    /**
     * Riwayat pesanan pasien
     */
    public function history()
    {
        $orders = Order::with('items.obat')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('pasien.order.orderhistory', compact('orders'));
    }



    /**
     * Upload bukti bayar (TRANSFER)
     */
    public function uploadBukti(Request $request, Order $order)
    {
        // keamanan: hanya pemilik order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($order->bukti_bayar) {
            Storage::disk('public')->delete($order->bukti_bayar);
        }

        $path = $request->file('bukti_bayar')
            ->store('bukti-bayar', 'public');

        $order->update([
            'bukti_bayar' => $path,
            'status' => 'diproses'
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload');
    }

    public function show(Order $order)
    {
        // Keamanan: hanya pemilik
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.obat');

        // Return partial view untuk isi modal
        return view('pasien.order.detail_modal_order', compact('order'));
    }
}