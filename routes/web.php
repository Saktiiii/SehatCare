<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriObatController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\NakesProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NakesController;
use App\Http\Controllers\PasienObatController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PasienController;


use Illuminate\Support\Facades\Auth;

// Route utama /dashboard - redirect sesuai role
Route::get('/dashboard', function () {
    $role = Auth::user()->role;

    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'nakes' => redirect()->route('nakes.dashboard'),
        'petugas' => redirect()->route('petugas.dashboard'), // kalau beda dari nakes
        'user', 'pasien' => redirect()->route('pasien.dashboard'),
        default => redirect()->route('pasien.dashboard'),
    };
})->middleware(['auth'])->name('dashboard');

// Dashboard Admin
Route::get('/admin/dashboard', [AdminController::class, 'index'])
    ->name('admin.dashboard')
    ->middleware(['auth']); // tambah proteksi role

// Dashboard Nakes
Route::get('/nakes/dashboard', [NakesController::class, 'index']) // PERBAIKI INI!
    ->name('nakes.dashboard')
    ->middleware(['auth']);

// Dashboard Petugas (jika berbeda dari nakes)
Route::get('/petugas/dashboard', [PetugasController::class, 'index'])
    ->name('petugas.dashboard')
    ->middleware(['auth']);

// Dashboard Pasien
Route::get('/pasien/dashboard', [PasienController::class, 'index'])
    ->name('pasien.dashboard')
    ->middleware(['auth']);


Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    //User
    Route::get('/admin/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/admin/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/admin/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/admin/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/admin/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/admin/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    // Kategori Obat
    Route::get('/admin/kategori-obat', [KategoriObatController::class, 'index'])->name('kategori.index');
    Route::post('/admin/kategori-obat', [KategoriObatController::class, 'store'])->name('kategori.store');
    Route::delete('/admin/kategori-obat/{id}', [KategoriObatController::class, 'destroy'])->name('kategori.destroy');

    // Obat
    Route::get('/admin/obat', [ObatController::class, 'index'])->name('obat.index');
    Route::post('/admin/obat', [ObatController::class, 'store'])->name('obat.store');
    Route::get('/admin/obat/{id}/edit', [ObatController::class, 'edit'])->name('obat.edit');
    Route::put('/admin/obat/{id}', [ObatController::class, 'update'])->name('obat.update');
    Route::delete('/admin/obat/{id}', [ObatController::class, 'destroy'])->name('obat.destroy');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/nakes', [NakesProfileController::class, 'show'])->name('nakes.profile.show');
    Route::get('/profile/nakes/edit', [NakesProfileController::class, 'edit'])->name('nakes.profile.edit');
    Route::put('/profile/nakes', [NakesProfileController::class, 'update'])->name('nakes.profile.update');
});


Route::middleware(['auth'])->group(function () {
    Route::get('chat/create', [ChatController::class, 'create'])->name('chat.create');
    Route::get('chat/history', [ChatController::class, 'history'])->name('chat.history');
    Route::post('chat/store', [ChatController::class, 'store'])->name('chat.store');
    Route::get('chat/{id}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('chat/{id}/send', [ChatController::class, 'sendMessage'])->name('chat.send');

});



Route::middleware(['auth'])->group(function () {
    Route::get('/nakes/dashboard', [NakesController::class, 'dashboard'])->name('nakes.dashboard');
    Route::get('/nakes/chat/{conversation}', [NakesController::class, 'chat'])->name('nakes.chat');
    Route::post('/nakes/chat/{conversation}/send', [NakesController::class, 'sendMessage'])->name('nakes.chat.send');
    Route::post('/nakes/status', [NakesController::class, 'updateStatus'])->name('nakes.status.update');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/obat', [PasienObatController::class, 'index'])->name('pasien.obat.index');
    Route::get('/obat/{id}', [PasienObatController::class, 'show'])->name('pasien.obat.show');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/pasien/checkout', [KeranjangController::class, 'checkout'])
        ->name('pasien.checkout');

    Route::post('/pasien/order', [KeranjangController::class, 'process'])
        ->name('pasien.order.store');

    // pasien
    Route::get('/pasien/order', [KeranjangController::class, 'history'])
        ->name('pasien.order.history');


    Route::get('/pasien/order/{order}', [KeranjangController::class, 'show'])
        ->name('pasien.order.show');

    // upload bukti bayar
    Route::post('/pasien/order/{order}/upload', [KeranjangController::class, 'uploadBukti'])
        ->name('pasien.order.upload');


});

Route::middleware(['auth'])->prefix('nakes')->group(function () {

    Route::get('/order', [OrderAdminController::class, 'index'])
        ->name('petugas.order.index');

    Route::get('/order/{order}', [OrderAdminController::class, 'show'])
        ->name('petugas.order.show');

    Route::post('/order/{order}/kirim', [OrderAdminController::class, 'kirim'])
        ->name('petugas.order.kirim');

    Route::post('/order/{order}/selesai', [OrderAdminController::class, 'selesai'])
        ->name('petugas.order.selesai');
});

