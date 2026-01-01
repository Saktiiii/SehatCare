<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriObat;
use App\Models\Obat;
use App\Models\NakesProfile;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin tetap
        User::factory()->admin()->create([
            'name'     => 'Admin SehatCare',
            'email'    => 'admin@sehatcare.com',
            'password' => Hash::make('password123'),
        ]);

        // 2. Petugas tetap (1 orang)
        User::factory()->petugas()->create([
            'name'     => 'Petugas Apotek Utama',
            'email'    => 'petugas@sehatcare.com',
            'password' => Hash::make('password123'),
        ]);

        // 3. Nakes tetap (1 orang) + profile lengkap
        $nakes = User::factory()->nakes()->create([
            'name'     => 'Dr. Sarah Putri',
            'email'    => 'sarah.dokter@sehatcare.com',
            'password' => Hash::make('password123'),
        ]);

        NakesProfile::factory()->create([
            'user_id'           => $nakes->id,
            'foto'              => 'nakes/sarah.jpg', // optional
            'alamat_praktek'    => 'Jl. Thamrin No. 45, Jakarta Pusat',
            'lulusan'           => 'Universitas Indonesia',
            'spesialisasi'      => 'Dokter Umum',
            'nomor_registrasi'  => 'STR9876543210',
            'pengalaman_kerja'  => 'Berpengalaman 8 tahun di RS Cipto Mangunkusumo dan praktek mandiri sejak 2020.',
        ]);

        // 4. Pasien tetap (1 orang)
        User::factory()->pasien()->create([
            'name'     => 'Ahmad Fauzi',
            'email'    => 'ahmad.pasien@sehatcare.com',
            'password' => Hash::make('password123'),
        ]);

        // 5. Kategori Obat (10 kategori)
        KategoriObat::factory(10)->create();

        // 6. Obat (50 obat dummy)
        Obat::factory(50)->create();
    }
}
