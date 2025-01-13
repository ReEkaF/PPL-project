<?php

namespace Database\Seeders;

use App\Models\Staffakademik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Staffakademik::factory()->count(5)->create();
    }
}
