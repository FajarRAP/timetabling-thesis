<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\TimetableEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TimetableEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Timetable $timetable)
    {
        $timetableEntries = TimetableEntry::where('timetable_id', $timetable->id)->get();
        $groupByRoomClass = $timetableEntries
            ->groupBy(fn(TimetableEntry $item) => $item->lectureSlot->roomClass->room_class)
            ->sortKeys();
        $sorted = $groupByRoomClass
            ->map(fn(Collection $item) => $item->sortBy([
                fn(TimetableEntry $first, TimetableEntry $second) => $first->lectureSlot->day->id <=> $second->lectureSlot->day->id,
                fn(TimetableEntry $first, TimetableEntry $second) => $first->lectureSlot->timeSlot->start_at <=> $second->lectureSlot->timeSlot->start_at,
            ]));

        return view('timetable-entry', [
            'timetable' => $timetable,
            'timetable_entries' => $timetableEntries,
            'sorted' => $sorted,
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
    public function store(Timetable $timetable, GeneticAlgorithmController $controller)
    {
        $result = $controller->generate();
        $fitnessScore = $result['population']['fitness_score'];
        $chromosome = collect($result['population']['chromosome']);
        $mappedChromosome = $chromosome->map(fn(array $item) => [
            'timetable_id' => $timetable->id,
            'lecture_id' => $item['lecture']['id'],
            'lecture_slot_id' => $item['lecture_slot']['id'],
        ])->values();

        $timetable->fitness_score = $fitnessScore;
        $timetable->save();

        $mappedChromosome->each(fn(array $item) => TimetableEntry::create($item));

        return redirect(route('timetable'))->with('success', 'Generate Timetable Entries Successful');
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
