<?php

namespace App\Http\Controllers;

use App\Models\RoomClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('room-class', [
            'roomClasses' => RoomClass::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_class' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['errors' => $validator->errors()],
                422,
            );
        }

        $roomClass = RoomClass::create($request->all());

        return response()->json([
            'message' => 'Successful',
            'data' => $roomClass,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(RoomClass $roomClass)
    {
        return response()->json([
            'message' => 'Successful',
            'data' => $roomClass,
        ]);
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

        return response()->json([
            'message' => 'Successful',
            'data' => $roomClass,
        ]);
    }
}
