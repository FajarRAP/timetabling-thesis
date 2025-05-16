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
        $violateSIMERU = [
            [
                'time_slot' => '07.00-08.40',
                'start_at' => '07:00:00',
                'end_at' => '08:40:00',
                'credit_hour' => 2,
            ],
            [
                'time_slot' => '07.50-09.35',
                'start_at' => '07:50:00',
                'end_at' => '09:35:00',
                'credit_hour' => 2,
            ],
            [
                'time_slot' => '08.45-10.25',
                'start_at' => '08:45:00',
                'end_at' => '10:25:00',
                'credit_hour' => 2,
            ],
            [
                'time_slot' => '09.35-11.20',
                'start_at' => '09:35:00',
                'end_at' => '11:20:00',
                'credit_hour' => 2,
            ],
            [
                'time_slot' => '10.30-12.10',
                'start_at' => '10:30:00',
                'end_at' => '12:10:00',
                'credit_hour' => 2,
            ],
            [
                'time_slot' => '11.20-13.20',
                'start_at' => '11:20:00',
                'end_at' => '13:20:00',
                'credit_hour' => 2,
            ],
            [
                'time_slot' => '12.30-14.10',
                'start_at' => '12:30:00',
                'end_at' => '14:10:00',
                'credit_hour' => 2,
            ],
            [
                'time_slot' => '13.20-15.05',
                'start_at' => '13:20:00',
                'end_at' => '15:05:00',
                'credit_hour' => 2,
            ],
            [
                'time_slot' => '14.15-16.05',
                'start_at' => '14:15:00',
                'end_at' => '16:05:00',
                'credit_hour' => 2,
            ],
            [
                'time_slot' => '15.15-17.00',
                'start_at' => '15:15:00',
                'end_at' => '17:00:00',
                'credit_hour' => 2,
            ],
            [
                'time_slot' => '16.10-17.50',
                'start_at' => '16:10:00',
                'end_at' => '17:50:00',
                'credit_hour' => 2,
            ],
            [
                'time_slot' => '07.00-09.35',
                'start_at' => '07:00:00',
                'end_at' => '09:35:00',
                'credit_hour' => 3,
            ],
            [
                'time_slot' => '07.50-10.25',
                'start_at' => '07:50:00',
                'end_at' => '10:25:00',
                'credit_hour' => 3,
            ],
            [
                'time_slot' => '08.45-11.20',
                'start_at' => '08:45:00',
                'end_at' => '11:20:00',
                'credit_hour' => 3,
            ],
            [
                'time_slot' => '09.35-12.10',
                'start_at' => '09:35:00',
                'end_at' => '12:10:00',
                'credit_hour' => 3,
            ],
            [
                'time_slot' => '10.30-13.20',
                'start_at' => '10:30:00',
                'end_at' => '13:20:00',
                'credit_hour' => 3,
            ],
            [
                'time_slot' => '11.20-14.10',
                'start_at' => '11:20:00',
                'end_at' => '14:10:00',
                'credit_hour' => 3,
            ],
            [
                'time_slot' => '12.30-15.05',
                'start_at' => '12:30:00',
                'end_at' => '15:05:00',
                'credit_hour' => 3,
            ],
            [
                'time_slot' => '13.20-16.05',
                'start_at' => '13:20:00',
                'end_at' => '16:05:00',
                'credit_hour' => 3,
            ],
            [
                'time_slot' => '14.10-17.00',
                'start_at' => '14:10:00',
                'end_at' => '17:00:00',
                'credit_hour' => 3,
            ],
            [
                'time_slot' => '15.15-17.50',
                'start_at' => '15:15:00',
                'end_at' => '17:50:00',
                'credit_hour' => 3,
            ],
        ];

        $unviolateSIMERU = [
            [
                'time_slot' => '07.00-08.40',
                'start_at' => '07:00:00',
                'end_at' => '08:40:00',
                'credit_hour' => 2,
            ],
            [
                'time_slot' => '08.45-10.25',
                'start_at' => '08:45:00',
                'end_at' => '10:25:00',
                'credit_hour' => 2,
            ],
            [
                'time_slot' => '10.30-12.10',
                'start_at' => '10:30:00',
                'end_at' => '12:10:00',
                'credit_hour' => 2,
            ],
            [
                'time_slot' => '12.30-14.10',
                'start_at' => '12:30:00',
                'end_at' => '14:10:00',
                'credit_hour' => 2,
            ],
            [
                'time_slot' => '14.15-16.05',
                'start_at' => '14:15:00',
                'end_at' => '16:05:00',
                'credit_hour' => 2,
            ],
            [
                'time_slot' => '16.10-17.50',
                'start_at' => '16:10:00',
                'end_at' => '17:50:00',
                'credit_hour' => 2,
            ],
            [
                'time_slot' => '07.00-09.35',
                'start_at' => '07:00:00',
                'end_at' => '09:35:00',
                'credit_hour' => 3,
            ],
            [
                'time_slot' => '09.35-12.10',
                'start_at' => '09:35:00',
                'end_at' => '12:10:00',
                'credit_hour' => 3,
            ],
            [
                'time_slot' => '12.30-15.05',
                'start_at' => '12:30:00',
                'end_at' => '15:05:00',
                'credit_hour' => 3,
            ],
            [
                'time_slot' => '15.15-17.50',
                'start_at' => '15:15:00',
                'end_at' => '17:50:00',
                'credit_hour' => 3,
            ],
        ];

        DB::table('time_slots')->insert($unviolateSIMERU);
    }
}
