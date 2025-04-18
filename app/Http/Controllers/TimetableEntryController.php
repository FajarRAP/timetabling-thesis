<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateTimetable;
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
        $sortByDay = fn(TimetableEntry $first, TimetableEntry $second)
        => $first->lectureSlot->day->id <=> $second->lectureSlot->day->id;
        $sortByTimeSlot = fn(TimetableEntry $first, TimetableEntry $second)
        => $first->lectureSlot->timeSlot->start_at <=> $second->lectureSlot->timeSlot->start_at;
        $mapSort = fn(Collection $item) => $item->sortBy([$sortByDay, $sortByTimeSlot]);

        $timetableEntries = TimetableEntry::where('timetable_id', $timetable->id)->get();
        $groupByRoomClass = $timetableEntries
            ->groupBy(fn(TimetableEntry $item) => $item->lectureSlot->roomClass->room_class)
            ->sortKeys();
        $sorted = $groupByRoomClass->map($mapSort);

        return view('timetable-entry', [
            'timetable' => $timetable,
            'timetable_entries_by_room_class' => $sorted,
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
    public function store(Request $request, Timetable $timetable)
    {
        $validated = $request->validateWithBag('generateEntries', [
            'max_generation' => ['nullable', 'integer', 'gt:1'],
            'population_size' => ['nullable', 'integer', 'gt:1'],
            'mutation_rate' => ['nullable', 'numeric', 'between:0,1'],
        ]);

        $params = [
            'max_generation' => $validated['max_generation'] ?? 1,
            'population_size' => $validated['population_size'] ?? 5,
            'mutation_rate' => $validated['mutation_rate'] ?? .2,
        ];

        GenerateTimetable::dispatch($params, $timetable);

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
