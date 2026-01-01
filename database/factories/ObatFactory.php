<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Obat;
use App\Models\KategoriObat;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Obat>
 */
class ObatFactory extends Factory
{
    protected $model = Obat::class;

    public function definition(): array
    {
        return [
            'nama_obat'   => $this->faker->unique()->words(3, true) . ' ' . $this->faker->randomElement(['Tablet', 'Kapsul', 'Sirup', 'Salep', 'Injeksi']),
            'kategori_id' => KategoriObat::inRandomOrder()->first()?->id ?? KategoriObat::factory(),
            'deskripsi'   => $this->faker->paragraph(2),
            'foto'        => 'obat/dummy.jpg', // atau null kalau belum ada foto
            'stok'        => $this->faker->numberBetween(20, 200),
            'harga'       => $this->faker->numberBetween(10000, 200000),
        ];
    }
}
