<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BobotGradesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = [
            ['grade' => 'E', 'maksimal' => 49.9, 'minimal' => 0],
            ['grade' => 'E+', 'maksimal' => 54.9, 'minimal' => 50],
            ['grade' => 'D', 'maksimal' => 59.9, 'minimal' => 55],
            ['grade' => 'D+', 'maksimal' => 64.9, 'minimal' => 60],
            ['grade' => 'C', 'maksimal' => 69.9, 'minimal' => 65],
            ['grade' => 'C+', 'maksimal' => 74.9, 'minimal' => 70],
            ['grade' => 'B', 'maksimal' => 79.9, 'minimal' => 75],
            ['grade' => 'B+', 'maksimal' => 84.9, 'minimal' => 80],
            ['grade' => 'A', 'maksimal' => 100, 'minimal' => 85],
        ];

        foreach ($grades as $grade) {
            DB::table('bobot_grades')->insert([
                'id_bobot_grade' => Str::uuid(),
                'grade' => $grade['grade'],
                'maksimal' => $grade['maksimal'],
                'minimal' => $grade['minimal'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
