<?php

namespace App\Http\Controllers;

use App\Http\Resources\LectureCollection;
use App\Http\Resources\LectureResource;
use App\Models\Lecture;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => 'Successful',
            'data' => new LectureCollection(Lecture::all()),
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
    public function show(Lecture $lecture)
    {
        return response()->json([
            'message' => 'Successful',
            'data' => new LectureResource($lecture),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lecture $lecture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecture $lecture)
    {
        //
    }
}
