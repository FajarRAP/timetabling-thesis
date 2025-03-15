<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamps = ['created_at' => now(), 'updated_at' => now()];

        DB::table('time_slots')->insert([
            ['time_slot' => '07.00-08.40', 'credit_hour' => 2, ...$timestamps],
            ['time_slot' => '08.45-10.25', 'credit_hour' => 2, ...$timestamps],
            ['time_slot' => '10.30-12.10', 'credit_hour' => 2, ...$timestamps],
            ['time_slot' => '12.30-14.10', 'credit_hour' => 2, ...$timestamps],
            ['time_slot' => '14.15-16.05', 'credit_hour' => 2, ...$timestamps],
            ['time_slot' => '16.10-17.50', 'credit_hour' => 2, ...$timestamps],
            ['time_slot' => '07.00-09.35', 'credit_hour' => 3, ...$timestamps],
            ['time_slot' => '09.35-12.10', 'credit_hour' => 3, ...$timestamps],
            ['time_slot' => '12.30-15.05', 'credit_hour' => 3, ...$timestamps],
            ['time_slot' => '15.15-17.50', 'credit_hour' => 3, ...$timestamps],
        ]);
    }
}
