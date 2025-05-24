<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\TimetableEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class TimetableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        return view('timetable', [
            'timetables' => Timetable::paginate(10)->appends(['per_page' => $perPage]),
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
        Timetable::create();

        return back()->with('success', 'Add Data Successful');
    }

    /**
     * Display the specified resource.
     */
    public function show(Timetable $timetable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Timetable $timetable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Timetable $timetable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timetable $timetable)
    {
        $timetable->delete();

        return back()->with('success', __('Delete Data Successful'));
    }

    public function exportSpreadsheet(Timetable $timetable)
    {
        $sortByDay = fn(TimetableEntry $first, TimetableEntry $second)
        => $first->lectureSlot->day->id <=> $second->lectureSlot->day->id;
        $sortByTimeSlot = fn(TimetableEntry $first, TimetableEntry $second)
        => $first->lectureSlot->timeSlot->start_at <=> $second->lectureSlot->timeSlot->start_at;
        // $mapSort = fn(Collection $item) => $item->sortBy([$sortByDay, $sortByTimeSlot]);
        $sortedEntries = $timetable->entries->sortBy([$sortByDay, $sortByTimeSlot])->values();

        $spreadsheet = new Spreadsheet();
        $activeSheet = $spreadsheet->getActiveSheet();
        $activeSheet->setTitle('Timetable');
        $activeSheet->setCellValue([1, 1], 'Day');
        $activeSheet->setCellValue([2, 1], 'Time Slot');
        $activeSheet->setCellValue([3, 1], 'Room Class');
        $activeSheet->setCellValue([4, 1], 'Lecture');
        foreach ($sortedEntries as $i => $v) {
            $activeSheet->setCellValue([1, $i + 2], $v->lectureSlot->day->day);
            $activeSheet->setCellValue([2, $i + 2], $v->lectureSlot->timeSlot->time_slot);
            $activeSheet->setCellValue([3, $i + 2], $v->lectureSlot->roomClass->room_class);
            $activeSheet->setCellValue([4, $i + 2], "{$v->lecture->course->course_name}/{$v->lecture->class}/{$v->lecture->lecturer->lecturer_name}");
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save("timetables/$timetable->id.xlsx");

        return back()->with('success', 'Export Spreadsheet Successful');
    }
}
