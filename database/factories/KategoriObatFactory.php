<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\KategoriObat;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KategoriObat>
 */
class KategoriObatFactory extends Factory
{
    protected $model = KategoriObat::class;

    public function definition(): array
    {
        return [
            'nama_kategori' => $this->faker->unique()->randomElement([
                'Antibiotik',
                'Analgesik & Antipiretik',
                'Vitamin & Suplemen',
                'Obat Batuk & Flu',
                'Obat Pencernaan',
                'Obat Jantung',
                'Antihipertensi',
                'Antidiabetes',
                'Obat Mata',
                'Obat Kulit',
                'Obat Saraf',
                'Obat Anak',
            ]),
        ];
    }
}
