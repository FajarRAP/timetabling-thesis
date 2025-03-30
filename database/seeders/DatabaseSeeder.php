<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DaySeeder::class,
            RoomClassSeeder::class,
            CourseSeeder::class,
            LecturerSeeder::class,
            LectureSeeder::class,
            TimeSlotSeeder::class,
            LectureSlotSeeder::class,
        ]);
    }
}
