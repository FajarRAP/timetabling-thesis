<?php

namespace App\Http\Controllers;

use App\Http\Resources\LectureSlotResource;
use App\Models\LectureSlot;
use Illuminate\Http\Request;

class LectureSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => 'Successful',
            'data' => LectureSlotResource::collection(LectureSlot::all()),

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
    public function show(LectureSlot $lectureSlot)
    {
        return response()->json([
            'message' => 'Successful',
            'data' => new LectureSlotResource($lectureSlot)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LectureSlot $lectureSlot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LectureSlot $lectureSlot)
    {
        //
    }
}
