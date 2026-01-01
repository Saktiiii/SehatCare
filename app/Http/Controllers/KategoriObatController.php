<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriObat;

class KategoriObatController extends Controller
{
    public function index()
    {
        $kategori = KategoriObat::all();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required'
        ]);

        KategoriObat::create($request->all());
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function destroy($id)
    {
        KategoriObat::findOrFail($id)->delete();
        return redirect()->back();
    }
}
