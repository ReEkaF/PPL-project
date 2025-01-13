<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guru>
 */
class GuruFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_guru' => $this->faker->uuid(),
            'nip' => $this->faker->unique()->numerify('##############'),
            'nama_guru' => $this->faker->name(),
            'alamat_guru' => $this->faker->address(),
            'foto_guru' => $this->faker->imageUrl(),
            'nomor_wa_guru' => $this->faker->phoneNumber(),
            'role_guru' => $this->faker->randomElement(['guru', 'pembina', 'wali_kelas']),
            'username' => $this->faker->userName(),
            'password' => bcrypt('password'),
            'email' => $this->faker->unique()->safeEmail(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
