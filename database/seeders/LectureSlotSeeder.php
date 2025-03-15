<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LectureSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [];

        for ($i = 0; $i < 6; $i++) { // Active Days (days)
            for ($j = 0; $j < 7; $j++) { // Total Available Class (room_classes)
                for ($k = 0; $k < 10; $k++) { // Time Slot (time_slots)
                    $datas[] = [
                        'day_id' => $i + 1,
                        'time_slot_id' => $k + 1,
                        'room_class_id' => $j + 1,
                    ];
                }
            }
        }

        DB::table('lecture_slots')->insert($datas);
    }
}
