<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\NakesProfile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NakesProfile>
 */
class NakesProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = NakesProfile::class;

    public function definition(): array
    {
        return [
            'foto'               => 'nakes/1.jpg', // dummy, bisa diganti
            'alamat_praktek'     => fake()->address(),
            'lulusan'            => fake()->randomElement(['Universitas Indonesia', 'Universitas Airlangga', 'Universitas Gadjah Mada']),
            'spesialisasi'       => fake()->randomElement(['Dokter Umum', 'Apoteker', 'Dokter Gigi', 'Dokter Spesialis Jantung']),
            'nomor_registrasi'   => 'STR' . fake()->unique()->numerify('##########'),
            'pengalaman_kerja'   => fake()->paragraph(2),
        ];
    }
}
