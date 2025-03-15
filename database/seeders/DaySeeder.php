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
        $timestamps = ['created_at' => now(), 'updated_at' => now()];

        DB::table('days')->insert([
            ['day' => 'Senin', ...$timestamps],
            ['day' => 'Selasa', ...$timestamps],
            ['day' => 'Rabu', ...$timestamps],
            ['day' => 'Kamis', ...$timestamps],
            ['day' => 'Jumat', ...$timestamps],
            ['day' => 'Sabtu', ...$timestamps],
        ]);
    }
}
