<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lecturer', [
            'lecturers' => Lecturer::paginate(10),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validateWithBag('addLecturer', [
            'lecturer_number' => 'required',
            'lecturer_name' => 'required',
        ]);

        Lecturer::create($validated);

        return redirect(route('lecturer'))->with('success', __('Add Data Successful'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Lecturer $lecturer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lecturer $lecturer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecturer $lecturer)
    {
        $lecturer->delete();

        return redirect(route('lecturer'))->with('success', __('Delete Data Successful'));
    }
}
