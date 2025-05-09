<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\LectureSlot;
use App\Models\LectureSlotConstraint;
use Illuminate\Http\Request;

class LectureSlotController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $lectureSlots = LectureSlot::where('is_excluded', false)->get();

        return view('lecture-slot', [
            'lecture_slots' => $lectureSlots,
            'lecture_slot_constraints' => LectureSlotConstraint::all(),
            'days' => Day::all(),
        ]);
    }
}
