<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Lecturer;
use App\Models\LecturerConstraint;
use Illuminate\Http\Request;

class LecturerConstraintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Lecturer $lecturer)
    {
        return view('lecturer-constraint', [
            'lecturer' => $lecturer,
            'days' => Day::all(),
            'constraints' => LecturerConstraint::where('lecturer_id', $lecturer->id)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $reqCollection = $request->collect('constraints');
        $mappedConstraints = $reqCollection->map(
            fn($item) =>
            [
                'lecturer_id' => $item['lecturer_id'],
                'lecture_id' => $item['lecture_id'],
                'day_id' => $item['day_id'] ?? null,
                'start_at' => $item['start_at'] ?? null,
                'end_at' => $item['end_at'] ?? null,
            ]
        );

        $mappedConstraints->each(
            function ($item) {
                // if (!$item['day_id'] && !$item['start_at'] && !$item['end_at']) return;

                LecturerConstraint::updateOrCreate(
                    ['lecturer_id' => $item['lecturer_id'], 'lecture_id' => $item['lecture_id']],
                    ['day_id' => $item['day_id'], 'start_at' => $item['start_at'], 'end_at' => $item['end_at']]
                );
            }
        );

        return redirect(route('lecturer'))->with('success', __('Add Constraints Successful'));
    }

    /**
     * Display the specified resource.
     */
    public function show(LecturerConstraint $lecturerConstraint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LecturerConstraint $lecturerConstraint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LecturerConstraint $lecturerConstraint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LecturerConstraint $lecturerConstraint)
    {
        //
    }
}
