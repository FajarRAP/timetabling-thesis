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
                    // Hari Jumat
                    if ($i == 5) {
                        // Jam 08.45-12.10
                        switch ($k) {
                            case 2:
                            case 3:
                            case 4:
                            case 5:
                            case 6:
                            case 14:
                            case 15:
                            case 16:
                            case 17:
                                continue 2;
                        }
                    }

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
