<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('room_classes')->insert([
            ['room_class' => '4.1.5.54'],
            ['room_class' => '4.1.5.55'],
            ['room_class' => '4.1.5.56'],
            ['room_class' => '4.1.5.57'],
            ['room_class' => '4.1.5.58'],
            ['room_class' => '4.1.5.59'],
            ['room_class' => '4.1.5.60'],
        ]);
    }
}
