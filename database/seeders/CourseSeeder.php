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
            // Semester 1
            ['course_name' => 'Dasar Pemrograman', 'credit_hour' => 3, 'is_has_practicum' => false, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Dasar Sistem Komputer', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Kalkulus Informatika', 'credit_hour' => 3, 'is_has_practicum' => false, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Logika Informatika', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Manajemen Data dan Informasi', 'credit_hour' => 3, 'is_has_practicum' => false, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Pancasila', 'credit_hour' => 2, 'is_has_practicum' => false, 'is_online' => true, 'is_even_semester' => false],
            ['course_name' => 'Alquran dan Hadits', 'credit_hour' => 2, 'is_has_practicum' => false, 'is_online' => true, 'is_even_semester' => false],
            // Semester 2
            ['course_name' => 'Aljabar Linear Matrik', 'credit_hour' => 2, 'is_has_practicum' => false, 'is_online' => false, 'is_even_semester' => true],
            ['course_name' => 'Algoritma Pemrograman', 'credit_hour' => 3, 'is_has_practicum' => false, 'is_online' => false, 'is_even_semester' => true],
            ['course_name' => 'Matematika Diskrit', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => true],
            ['course_name' => 'Pemrograman Web', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => true],
            ['course_name' => 'Arsitektur Komputer', 'credit_hour' => 3, 'is_has_practicum' => false, 'is_online' => false, 'is_even_semester' => true],
            ['course_name' => 'Akhlak', 'credit_hour' => 2, 'is_has_practicum' => false, 'is_online' => true, 'is_even_semester' => true],
            ['course_name' => 'Bahasa Indonesia', 'credit_hour' => 2, 'is_has_practicum' => false, 'is_online' => true, 'is_even_semester' => true],
            ['course_name' => 'Pendidikan Kewarganegaraan', 'credit_hour' => 2, 'is_has_practicum' => false, 'is_online' => true, 'is_even_semester' => true],
            // Semester 3
            ['course_name' => 'Basis Data', 'credit_hour' => 4, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Pemrograman Berorientasi Objek', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Sistem Operasi', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Statistika Informatika', 'credit_hour' => 4, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Struktur Data', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Aqidah Islam', 'credit_hour' => 2, 'is_has_practicum' => false, 'is_online' => true, 'is_even_semester' => false],
            ['course_name' => 'Bahasa Inggris', 'credit_hour' => 2, 'is_has_practicum' => false, 'is_online' => true, 'is_even_semester' => false],
            // Semester 4
            ['course_name' => 'Analisis dan Perancangan Perangkat Lunak', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => true],
            ['course_name' => 'Interaksi Manusia dan Komputer', 'credit_hour' => 3, 'is_has_practicum' => false, 'is_online' => false, 'is_even_semester' => true],
            ['course_name' => 'Kecerdasan Buatan', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => true],
            ['course_name' => 'Grafika Komputer', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => true],
            ['course_name' => 'Komunikasi Data dan Jaringan Komputer', 'credit_hour' => 3, 'is_has_practicum' => false, 'is_online' => false, 'is_even_semester' => true],
            ['course_name' => 'Strategi Algoritma', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => true],
            ['course_name' => 'Islam Interdisipliner', 'credit_hour' => 2, 'is_has_practicum' => false, 'is_online' => true, 'is_even_semester' => true],
            // Semester 5
            ['course_name' => 'Keamanan Komputer', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Pemrograman Mobile', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Forensik Digital', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Grafika Terapan', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Pemrograman Web Dinamis', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Penambangan Data', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Penjaminan Kualitas Perangkat Lunak', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Teknik Optimasi', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Pembelajaran Mesin', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Pengolahan Citra', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Robotika Informatika', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Sistem Pendukung Keputusan', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Sistem Temu Balik Informasi', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => false],
            ['course_name' => 'Kemuhammadiyahan', 'credit_hour' => 2, 'is_has_practicum' => false, 'is_online' => true, 'is_even_semester' => false],
            ['course_name' => 'Pengantar Manajemen dan Prinsip Proyek', 'credit_hour' => 2, 'is_has_practicum' => false, 'is_online' => true, 'is_even_semester' => false],
            ['course_name' => 'Teori Bahasa Otomata', 'credit_hour' => 2, 'is_has_practicum' => false, 'is_online' => true, 'is_even_semester' => false],
            // Semester 6
            ['course_name' => 'Tahsinul Quran', 'credit_hour' => 2, 'is_has_practicum' => false, 'is_online' => false, 'is_even_semester' => true],
            ['course_name' => 'Rekayasa Perangkat Lunak', 'credit_hour' => 3, 'is_has_practicum' => false, 'is_online' => false, 'is_even_semester' => true],
            ['course_name' => 'Rekayasa Web', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => true],
            ['course_name' => 'Sistem Informasi Geografis', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => true],
            ['course_name' => 'Pembelajaran Mendalam', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => true],
            ['course_name' => 'Pengembangan Aplikasi Game', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => true],
            ['course_name' => 'Kriptografi', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => false, 'is_even_semester' => true],
            ['course_name' => 'Manajemen Proyek Teknologi Informasi', 'credit_hour' => 2, 'is_has_practicum' => false, 'is_online' => true, 'is_even_semester' => true],
            ['course_name' => 'Metodologi Penelitian', 'credit_hour' => 2, 'is_has_practicum' => false, 'is_online' => true, 'is_even_semester' => true],
            ['course_name' => 'Teknologi Multimedia', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => true, 'is_even_semester' => true],
            ['course_name' => 'Keamanan Informasi', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => true, 'is_even_semester' => true],
            ['course_name' => 'Sistem terdistribusi', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => true, 'is_even_semester' => true],
            ['course_name' => 'Visualisasi Data', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => true, 'is_even_semester' => true],
            ['course_name' => 'Pemrosesan Bahasa Alami', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => true, 'is_even_semester' => true],
            ['course_name' => 'Pengenalan Pola', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => true, 'is_even_semester' => true],
            ['course_name' => 'Penglihatan Komputer', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => true, 'is_even_semester' => true],
            // Semester 7
            ['course_name' => 'Bahasa Inggris Professional', 'credit_hour' => 2, 'is_has_practicum' => false, 'is_online' => true, 'is_even_semester' => false],
            ['course_name' => 'Kapita Selekta', 'credit_hour' => 3, 'is_has_practicum' => false, 'is_online' => true, 'is_even_semester' => false],
            ['course_name' => 'Kewirausahaan', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => true, 'is_even_semester' => false],
            ['course_name' => 'Komunikasi Interpersonal', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => true, 'is_even_semester' => false],
            ['course_name' => 'Sosio Informatika', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => true, 'is_even_semester' => false],
            ['course_name' => 'Fiqih Ibadah', 'credit_hour' => 3, 'is_has_practicum' => true, 'is_online' => true, 'is_even_semester' => false],
            // Semester 8
            ['course_name' => 'Ilmu Dakwah', 'credit_hour' => 2, 'is_has_practicum' => false, 'is_online' => true, 'is_even_semester' => true],
        ]);
    }
}
