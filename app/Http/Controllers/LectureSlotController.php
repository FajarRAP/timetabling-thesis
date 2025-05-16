<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\LectureSlot;
use App\Models\LectureSlotConstraint;
use App\Models\RoomClass;
use App\Models\TimeSlot;
use Illuminate\Http\Request;

class LectureSlotController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $day = $request->query('day');
        $timeSlot = $request->query('time_slot');
        $roomClass = $request->query('room_class');
        $lectureSlots = LectureSlot::whereNull('lecture_slot_constraint_id');

        if ($day) {
            $lectureSlots = $lectureSlots->where('day_id', $day);
        }

        if ($timeSlot) {
            $lectureSlots = $lectureSlots->where('time_slot_id', $timeSlot);
        }

        if ($roomClass) {
            $lectureSlots = $lectureSlots->where('room_class_id', $roomClass);
        }

        return view('lecture-slot', [
            'lecture_slots' => $lectureSlots
                ->paginate($perPage)
                ->appends([
                    'per_page' => $perPage,
                    'day' => $day,
                    'time_slot' => $timeSlot,
                    'room_class' => $roomClass
                ]),
            'lecture_slot_constraints' => LectureSlotConstraint::all(),
            'days' => Day::all(),
            'time_slots' => TimeSlot::all(),
            'room_classes' => RoomClass::all(),
        ]);
    }
}
