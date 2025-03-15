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
        return response()->json([
            'message' => 'Successful',
            'data' => RoomClass::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }
}
