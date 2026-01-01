<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ===== LOGIN =====
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors([
                'login_error' => 'Email atau password salah!'
            ])->withInput();
        }
        // Setelah berhasil login, redirect sesuai role
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');  // route admin dashboard
            case 'nakes':
                return redirect()->route('nakes.dashboard');  // route nakes dashboard
            case 'petugas':
                return redirect()->route('petugas.dashboard');  // route Petugas dashboard
            case 'user':
                return redirect()->route('pasien.dashboard');             // route halaman user/pasien
        }
    }

    // ===== REGISTER =====
    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat');
    }

    // ===== LOGOUT =====
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
