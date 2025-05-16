<?php

namespace App\Http\Controllers;

use App\Models\LectureSlot;
use App\Models\LectureSlotConstraint;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LectureSlotConstraintController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validateWithBag('addLectureSlotConstraint', [
            'day' => ['required', 'exists:days,id'],
            'start_at' => ['required', 'date_format:H:i', 'before:end_at'],
            'end_at' => ['required', 'date_format:H:i', 'after:start_time'],
        ]);

        $lectureSlots = LectureSlot::all();

        $lectureSlotConstraint = LectureSlotConstraint::create([
            'day_id' => $validated['day'],
            'start_at' => $validated['start_at'],
            'end_at' => $validated['end_at'],
        ]);

        $filtered = $lectureSlots->where(fn($item) => $item->day_id == $validated['day'])->values();

        $filtered->each(function ($lectureSlot) use ($validated, $lectureSlotConstraint) {
            if (Carbon::parse($lectureSlot->timeSlot->end_at) >= Carbon::parse($validated['start_at']) && Carbon::parse($lectureSlot->timeSlot->start_at) <= Carbon::parse($validated['end_at'])) {
                $lectureSlot->lecture_slot_constraint_id = $lectureSlotConstraint->id;
                $lectureSlot->save();
            }
        });

        return redirect(route('lecture-slot'))->with('success', 'Lecture slot constraint added successfully.');
    }

    public function destroy(Request $request, LectureSlotConstraint $constraint)
    {
        $lectureSlots = LectureSlot::all();
        $filtered = $lectureSlots
            ->where(fn($item) => $item->lecture_slot_constraint_id == $constraint->id)
            ->values();
        $filtered->each(function ($lectureSlot) {
            $lectureSlot->lecture_slot_constraint_id = null;
            $lectureSlot->save();
        });
        $constraint->delete();

        return redirect(route('lecture-slot'))->with('success', 'Lecture slot constraint deleted successfully.');
    }
}
