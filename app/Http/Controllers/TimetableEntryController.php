<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\TimetableEntry;
use Illuminate\Http\Request;

class TimetableEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Timetable $timetable)
    {
        return view('timetable-entry', [
            'timetable' => $timetable,
            'timetable_entries' => TimetableEntry::where('timetable_id', $timetable->id)->get()
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
    public function store(Request $request, GeneticAlgorithmController $controller)
    {
        $timetableId = $request->input('timetable_id');

        $result = $controller->generate();
        $fitnessScore = $result['population']['fitness_score'];
        $chromosome = collect($result['population']['chromosome']);
        $mappedChromosome = $chromosome->map(fn(array $item, int $key) => [
            'timetable_id' => $timetableId,
            'lecture_id' => $item['lecture']['id'],
            'lecture_slot_id' => $item['lecture_slot']['id'],
        ])->values();

        $timetable = Timetable::find($timetableId);
        $timetable->fitness_score = $fitnessScore;
        $timetable->save();

        $mappedChromosome->each(fn(array $item) => TimetableEntry::create($item));

        return response()->json([
            'message' => 'Successful',
            'data' => [
                'fitness_score' => $fitnessScore,
                'chromosome' => $chromosome,
                'mapped_chromosome' => $mappedChromosome,
            ],
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TimetableEntry $timetableEntry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimetableEntry $timetableEntry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TimetableEntry $timetableEntry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimetableEntry $timetableEntry)
    {
        //
    }
}
