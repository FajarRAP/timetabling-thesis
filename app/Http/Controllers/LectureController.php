<?php

namespace App\Http\Controllers;

use App\Http\Resources\LectureResource;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LectureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lecture', [
            'lectures' => Lecture::all(),
            'courses' => Course::all(),
            'lecturers' => Lecturer::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
            'lecturer_id' => 'required',
            'class' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $lecture = Lecture::create($request->all());

        return response()->json([
            'message' => 'Successful',
            'data' => $lecture,
        ], 201);
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
        $lecture->delete();

        return response()->json([
            'message' => 'Successful',
            'data' => $lecture,
        ]);
    }
}
