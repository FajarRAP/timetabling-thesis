<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\TimetableUsedConstraint;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Time;

class TimetableUsedConstraintController extends Controller
{
    public function index(Timetable $timetable)
    {
        $constraints = TimetableUsedConstraint::where('timetable_id', $timetable->id)->get();

        return view('timetable-used-constraint', [
            'timetable' => $timetable,
            'lecture_slot_constraints' => $constraints->whereNull('lecturer_constraint_id')->values(),
            'lecturer_constraints' => $constraints->whereNull('lecture_slot_constraint_id')->values(),
        ]);
    }
}
