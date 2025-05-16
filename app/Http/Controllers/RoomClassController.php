<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\LectureSlot;
use App\Models\RoomClass;
use App\Models\TimeSlot;
use Illuminate\Http\Request;

class RoomClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        return view('room-class', [
            'roomClasses' => RoomClass::paginate(10)->appends(['per_page' => $perPage]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validateWithBag('addRoomClass', [
            'room_class' => 'required',
        ]);

        $roomClass = RoomClass::create($validated);

        if ($roomClass) {
            $days = Day::all();
            $timeSlots = TimeSlot::all();
            foreach ($days as $day) {
                foreach ($timeSlots as $timeslot) {
                    LectureSlot::create([
                        'day_id' => $day->id,
                        'time_slot_id' => $timeslot->id,
                        'room_class_id' => $roomClass->id,
                    ]);
                }
            }
        }

        return redirect(route('room-class'))->with('success', __('Add Data Successful'));
    }

    /**
     * Display the specified resource.
     */
    public function show(RoomClass $roomClass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoomClass $roomClass)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomClass $roomClass)
    {
        $roomClass->delete();

        return redirect(route('room-class'))->with('success', __('Delete Data Successful'));
    }
}
