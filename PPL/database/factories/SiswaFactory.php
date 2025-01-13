<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_siswa' => $this->faker->uuid(),
            'nisn' => $this->faker->unique()->numerify('##############'),
            'nama_siswa' => $this->faker->name(),
            'tgl_lahir_siswa' => $this->faker->date(),
            'jenis_kelamin_siswa' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'alamat_siswa' => $this->faker->address(),
            'foto_siswa' => $this->faker->imageUrl(),
            'nomor_wa_siswa' => $this->faker->phoneNumber(),
            'role_siswa' => $this->faker->randomElement(['siswa', 'pengurus']),
            'username' => $this->faker->userName(),
            'password' => bcrypt('password'),
            'email' => $this->faker->unique()->safeEmail(),
            'created_at' => now(),
            'updated_at' => now(),

        ];
    }
}
