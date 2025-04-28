<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\LectureSlot;
use Illuminate\Http\Request;

class LectureSlotController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('lecture-slot', [
            'lecture_slots' => LectureSlot::all(),
            'days' => Day::all(),
        ]);
    }
}
