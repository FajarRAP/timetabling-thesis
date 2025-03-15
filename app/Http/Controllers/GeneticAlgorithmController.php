<?php

namespace App\Http\Controllers;

use App\Http\Resources\LectureResource;
use App\Http\Resources\LectureSlotResource;
use App\Models\Lecture;
use App\Models\LectureSlot;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class GeneticAlgorithmController extends Controller
{
    public function generate()
    {
        // Dosen yang bentrok:
        // - waktu yang sama dengan ruangan yang sama

        // PR BROWW:
        // - konfliknya diitung 2x, padahal sama hanya tertukar posisi index saja, e.g.: ada di excel

        $populationSize = 1;
        $population = $this->initializePopulation($populationSize, true);
        $collections = [];
        $filteredCollections = [];
        $conflictCounts = [];

        for ($i = 0; $i < $populationSize; $i++) {
            $conflictCounts[] = 0;
            $collections[] = collect($population[$i]);

            $collections[$i] = $collections[$i]->filter(
                fn(array $value, int $key) =>
                $value['lecture']['course']['credit_hour'] == 3
            )->values();

            $filteredCollections[] = $collections[$i]->map(
                fn(array $value, int $key) =>
                [
                    'id' => $key,
                    'lecture' => [
                        'course_name' => $value['lecture']->course->course_name,
                        'class' => $value['lecture']->class,
                        'lecturer_name' => $value['lecture']->lecturer->lecturer_name,
                    ],
                    'lecture_slot' => [
                        'day' => $value['lecture_slot']->day->day,
                        'time_slot' => $value['lecture_slot']->timeSlot->time_slot,
                        'room_class' => $value['lecture_slot']->roomClass->room_class,
                    ],
                ]
            );

            foreach ($filteredCollections[$i] as $key => $value) {
                foreach ($filteredCollections[$i] as $k => $v) {
                    // $isSameLecturer = $value['lecture']['lecturer_name'] == $v['lecture']['lecturer_name'];
                    $isSameRoomClass = $value['lecture_slot']['room_class'] == $v['lecture_slot']['room_class'];
                    $isSameTimeSlot = $value['lecture_slot']['time_slot'] == $v['lecture_slot']['time_slot'];
                    $isSameDay = $value['lecture_slot']['day'] == $v['lecture_slot']['day'];
                    $isNotSameLecture = $key != $k;

                    if ($isSameRoomClass && $isSameTimeSlot && $isSameDay && $isNotSameLecture) {
                        $conflictCounts[$i]++;
                    }
                }
            }
        }

        $data = [];

        for ($i = 0; $i < $populationSize; $i++) {
            $cromosomeLength = count($filteredCollections[$i]);
            $data[] = [
                'chromosome_length' => $cromosomeLength,
                'conflict_count' => $conflictCounts[$i],
                'fitness_score' => $cromosomeLength / ($cromosomeLength + $conflictCounts[$i]),
                'conflict_count_normalized' => $conflictCounts[$i] / 2,
                'fitness_score_normalized' => $cromosomeLength / ($cromosomeLength + $conflictCounts[$i] / 2),
            ];
        }
        return response()->json([
            'message' => 'Successful',
            'population_size' => count($population),
            'population' => $data,
            'chromosome' => $filteredCollections[0],
        ]);
    }

    private function initializeChromosome(bool $withRandomizeNumber = false): array
    {
        $lectures =  LectureResource::collection(Lecture::all());
        [$twoCreditLectureSlots, $threeCreditLectureSlots] = $this->splitLectureSlotsByCreditHour();
        $lecturesCount = $lectures->count();
        $timetable = [];

        for ($i = 0; $i < $lecturesCount; $i++) {
            if ($lectures[$i]->course->credit_hour === 2) {
                $lectureSlot = $twoCreditLectureSlots->random();
                $timetable[] = $withRandomizeNumber ? ['lecture' => new LectureResource(Lecture::find($i + 1)), 'lecture_slot' => new LectureSlotResource($lectureSlot)] : ['lecture_id' => $i + 1, 'lecture_slot_id' => $lectureSlot->id];
            } else {
                $lectureSlot = $threeCreditLectureSlots->random();
                $timetable[] = $withRandomizeNumber ? ['lecture' => new LectureResource(Lecture::find($i + 1)), 'lecture_slot' => new LectureSlotResource($lectureSlot)] : ['lecture_id' => $i + 1, 'lecture_slot_id' => $lectureSlot->id];
            }
        }

        return $timetable;
    }

    private function initializePopulation(int $populationSize, bool $withRandomizeNumber = false): array
    {
        $population = [];

        for ($i = 0; $i < $populationSize; $i++) {
            $population[] = $this->initializeChromosome($withRandomizeNumber);
        }

        return $population;
    }

    private function splitLectureSlotsByCreditHour(): array
    {
        $isTwoCreditHour = fn(JsonResource $item) => $item->timeSlot->credit_hour === 2;
        $isThreeCreditHour = fn(JsonResource $item) => $item->timeSlot->credit_hour === 3;
        $lectureSlots = LectureSlotResource::collection(LectureSlot::all());

        $twoCreditLectureSlots = collect($lectureSlots)->filter($isTwoCreditHour);
        $threeCreditLectureSlots = collect($lectureSlots)->filter($isThreeCreditHour);

        return [$twoCreditLectureSlots, $threeCreditLectureSlots];
    }
}
