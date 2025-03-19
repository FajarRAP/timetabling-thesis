<?php

namespace Database\Seeders;

use App\Models\Day;
use App\Models\RoomClass;
use App\Models\TimeSlot;
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
        $dayCount = Day::count();
        $roomClassCount = RoomClass::count();
        $timeSlotCount = TimeSlot::count();
        $datas = [];

        for ($i = 0; $i < $dayCount; $i++) { // Active Days (days)
            for ($j = 0; $j < $roomClassCount; $j++) { // Total Available Class (room_classes)
                for ($k = 0; $k < $timeSlotCount; $k++) { // Time Slot (time_slots)
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
