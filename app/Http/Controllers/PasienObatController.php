<?php

namespace App\Http\Controllers;


use App\Models\Obat;
use App\Models\KategoriObat;
use Illuminate\Http\Request;

class PasienObatController extends Controller
{
/**
     * Halaman cari obat (LIST)
     */
    public function index(Request $request)
    {
        $kategori = KategoriObat::all();

        $obat = Obat::with('kategori')
            ->when($request->search, function ($q) use ($request) {
                $q->where('nama_obat', 'like', '%' . $request->search . '%');
            })
            ->when($request->kategori, function ($q) use ($request) {
                $q->where('kategori_id', $request->kategori);
            })
            ->orderBy('nama_obat')
            ->paginate(8)
            ->withQueryString(); // penting utk pagination + filter

        return view('pasien.obat.index', compact('obat', 'kategori'));
    }

    /**
     * Detail obat
     */
    public function show($id)
    {
        $obat = Obat::with('kategori')->findOrFail($id);

        return view('pasien.obat.show', compact('obat'));
    }
}
