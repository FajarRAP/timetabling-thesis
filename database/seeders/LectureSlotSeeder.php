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

        for ($i = 1; $i <= $dayCount; $i++) { // Active Days (days)
            for ($j = 1; $j <= $roomClassCount; $j++) { // Total Available Class (room_classes)
                for ($k = 1; $k <= $timeSlotCount; $k++) { // Time Slot (time_slots)
                    $datas[] = [
                        'day_id' => $i,
                        'time_slot_id' => $k,
                        'room_class_id' => $j,
                    ];
                }
            }
        }

        DB::table('lecture_slots')->insert($datas);
    }
}
