<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->insert([
            ['course_name' => 'Algoritma Pemrograman', 'credit_hour' => 3, 'is_has_practicum' => false],
            ['course_name' => 'Aljabar Linear Matrik', 'credit_hour' => 2, 'is_has_practicum' => false],
            ['course_name' => 'Arsitektur Komputer', 'credit_hour' => 3, 'is_has_practicum' => false],
            ['course_name' => 'Bahasa Indonesia', 'credit_hour' => 2, 'is_has_practicum' => false],
            ['course_name' => 'Matematika Diskrit', 'credit_hour' => 3, 'is_has_practicum' => true],
            ['course_name' => 'Pemrograman Web', 'credit_hour' => 3, 'is_has_practicum' => true],
            ['course_name' => 'Pendidikan Kewarganegaraan', 'credit_hour' => 2, 'is_has_practicum' => false],
            ['course_name' => 'Analisis dan Perancangan Perangkat Lunak', 'credit_hour' => 3, 'is_has_practicum' => false],
            ['course_name' => 'Grafika Komputer', 'credit_hour' => 3, 'is_has_practicum' => true],
            ['course_name' => 'Interaksi Manusia dan Komputer', 'credit_hour' => 3, 'is_has_practicum' => false],
            ['course_name' => 'Kecerdasan Buatan', 'credit_hour' => 3, 'is_has_practicum' => true],
            ['course_name' => 'Komunikasi Data dan Jaringan Komputer', 'credit_hour' => 3, 'is_has_practicum' => false],
            ['course_name' => 'Strategi Algoritma', 'credit_hour' => 3, 'is_has_practicum' => true],
            ['course_name' => 'Manajemen Proyek Teknologi Informasi', 'credit_hour' => 2, 'is_has_practicum' => false],
            ['course_name' => 'Metodologi Penelitian', 'credit_hour' => 2, 'is_has_practicum' => false],
            ['course_name' => 'Rekayasa Perangkat Lunak', 'credit_hour' => 3, 'is_has_practicum' => false],
            ['course_name' => 'Teknologi Multimedia', 'credit_hour' => 3, 'is_has_practicum' => true],
            ['course_name' => 'Keamanan Informasi', 'credit_hour' => 3, 'is_has_practicum' => true],
            ['course_name' => 'Kriptografi', 'credit_hour' => 3, 'is_has_practicum' => true],
            ['course_name' => 'Rekayasa Web', 'credit_hour' => 3, 'is_has_practicum' => true],
            ['course_name' => 'Sistem Informasi Geografis', 'credit_hour' => 3, 'is_has_practicum' => true],
            ['course_name' => 'Sistem terdistribusi', 'credit_hour' => 3, 'is_has_practicum' => true],
            ['course_name' => 'Visualisasi Data', 'credit_hour' => 3, 'is_has_practicum' => true],
            ['course_name' => 'Deep learning', 'credit_hour' => 3, 'is_has_practicum' => true],
            ['course_name' => 'Pemrosesan Bahasa Alami', 'credit_hour' => 3, 'is_has_practicum' => true],
            ['course_name' => 'Pengembangan Aplikasi Game', 'credit_hour' => 3, 'is_has_practicum' => true],
            ['course_name' => 'Pengenalan Pola', 'credit_hour' => 3, 'is_has_practicum' => true],
            ['course_name' => 'Penglihatan Komputer', 'credit_hour' => 3, 'is_has_practicum' => true],
        ]);
    }
}
