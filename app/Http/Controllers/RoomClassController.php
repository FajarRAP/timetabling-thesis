<?php

namespace App\Http\Controllers;

use App\Models\RoomClass;
use Illuminate\Http\Request;

class RoomClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('room-class', [
            'roomClasses' => RoomClass::paginate(5),
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

        RoomClass::create($validated);

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
