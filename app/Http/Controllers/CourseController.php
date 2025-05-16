<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $perPage = $request->input('per_page', 10);
        $creditHour = $request->query('credit_hour');
        $isHasPracticum = $request->query('is_has_practicum');
        $isOnline = $request->query('is_online');
        $isEvenSemester = $request->query('is_even_semester');
        $course = Course::query();

        if ($creditHour) {
            $course = $course->where('credit_hour', '=', $creditHour);
        }

        $course = match ($isHasPracticum) {
            'is_has_practicum' => $course->where('is_has_practicum', '=', 1),
            'is_not_has_practicum' => $course->where('is_has_practicum', '=', 0),
            default => $course,
        };

        $course = match ($isOnline) {
            'is_online' => $course->where('is_online', '=', 1),
            'is_not_online' => $course->where('is_online', '=', 0),
            default => $course,
        };

        $course = match ($isEvenSemester) {
            'is_even_semester' => $course->where('is_even_semester', '=', 1),
            'is_not_even_semester' => $course->where('is_even_semester', '=', 0),
            default => $course,
        };

        return view('course', [
            'courses' => $course
                ->paginate(10)
                ->appends([
                    'per_page' => $perPage,
                    'credit_hour' => $creditHour,
                    'is_has_practicum' => $isHasPracticum,
                    'is_online' => $isOnline,
                    'is_even_semester' => $isEvenSemester,
                ]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validateWithBag('addCourse', [
            'course_name' => 'required',
            'credit_hour' => 'required',
        ]);

        Course::create($validated);

        return redirect(route('course'))->with('success', __('Add Data Successful'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect(route('course'))->with('success', __('Delete Data Successful'));
    }
}
