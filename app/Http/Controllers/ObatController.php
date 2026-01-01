<?php

namespace App\Http\Controllers;


use App\Models\Obat;
use App\Models\KategoriObat;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class ObatController extends Controller
{
    public function index()
    {
        $obat = Obat::with('kategori')->get();
        $kategori = KategoriObat::all();
        return view('admin.obat.index', compact('obat', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_obat,id',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048', // max 2MB
        ]);

        $data = $request->all();

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('obat', 'public');
            $data['foto'] = $path;
        }

        Obat::create($data);

        return redirect()->back()->with('success', 'Obat berhasil ditambahkan');
    }

    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        $kategori = KategoriObat::all();
        return view('admin.obat.edit', compact('obat', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_obat,id',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $obat = Obat::findOrFail($id);
        $data = $request->all();

        // Jika ada foto baru, hapus foto lama dan upload foto baru
        if ($request->hasFile('foto')) {
            if ($obat->foto && Storage::disk('public')->exists($obat->foto)) {
                Storage::disk('public')->delete($obat->foto);
            }
            $path = $request->file('foto')->store('obat', 'public');
            $data['foto'] = $path;
        }

        $obat->update($data);

        return redirect()->route('obat.index')->with('success', 'Obat berhasil diperbarui');
    }

    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        // Hapus foto jika ada
        if ($obat->foto && Storage::disk('public')->exists($obat->foto)) {
            Storage::disk('public')->delete($obat->foto);
        }
        $obat->delete();
        return redirect()->back()->with('success', 'Obat berhasil dihapus');
    }
}
