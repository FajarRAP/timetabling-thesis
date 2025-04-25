<?php

namespace App\Http\Controllers;

use App\Http\Resources\LectureResource;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lecture', [
            'lectures' => Lecture::paginate(10),
            'courses' => Course::all(),
            'lecturers' => Lecturer::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validateWithBag('addLecture', [
            'course_id' => 'required',
            'lecturer_id' => 'required',
            'class' => 'required',
        ]);

        Lecture::create($validated);

        return redirect(route('lecture'))->with('success', __('Add Data Successful'));
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

        return redirect(route('lecture'))->with('success', __('Delete Data Successful'));
    }
}
