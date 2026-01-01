<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NakesProfile;
use Illuminate\Support\Facades\Auth;



class NakesProfileController extends Controller
{
    // Tampilkan profil nakes yang sedang login
    public function show()
    {
        $user = Auth::user();

        if ($user->role !== 'nakes') {
            abort(403, 'Unauthorized');
        }

        $profile = $user->nakesProfile;

        return view('profile.nakes.show', compact('profile'));
    }

    // Form edit profil
    public function edit()
    {
        $user = Auth::user();

        if ($user->role !== 'nakes') {
            abort(403, 'Unauthorized');
        }

        $profile = $user->nakesProfile;

        return view('profile.nakes.edit', compact('profile'));
    }

    // Update profil nakes
    public function update(Request $request)
    {
        $user = Auth::user();
    
        if ($user->role !== 'nakes') {
            abort(403, 'Unauthorized');
        }
    
        $data = $request->validate([
            'alamat_praktek'      => 'nullable|string|max:255',
            'lulusan'             => 'nullable|string|max:255',
            'spesialisasi'        => 'nullable|string|max:255',
            'nomor_registrasi'    => 'nullable|string|max:255',
            'pengalaman_kerja'    => 'nullable|string',
            'foto'                => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);
    
        $profile = $user->nakesProfile ?? new NakesProfile(['user_id' => $user->id]);
    
        // Handle upload foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($profile->exists && $profile->foto) {
                \Storage::disk('public')->delete('nakes_photos/' . $profile->foto);
            }
    
            $fotoName = time() . '_' . $request->foto->getClientOriginalName();
            $request->foto->storeAs('nakes_photos', $fotoName, 'public');
            $data['foto'] = $fotoName;
        }
    
        $profile->fill($data)->save();
    
        return redirect()->route('nakes.profile.show')->with('success', 'Profil berhasil diperbarui');
    }
}
