<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('days')->insert([
            ['day' => 'Senin'],
            ['day' => 'Selasa'],
            ['day' => 'Rabu'],
            ['day' => 'Kamis'],
            ['day' => 'Jumat'],
            ['day' => 'Sabtu'],
        ]);
    }
}
