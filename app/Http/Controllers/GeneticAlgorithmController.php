<?php

namespace App\Http\Controllers;

use App\Http\Resources\LectureResource;
use App\Http\Resources\LectureSlotResource;
use App\Models\Lecture;
use App\Models\LectureSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class GeneticAlgorithmController extends Controller
{
    public function generate()
    {
        /**
         * PR BROWW:
         * - konfliknya diitung 2x, padahal sama hanya tertukar posisi index saja, e.g.: ada di excel -> sementara dibagi 2 dulu, awoakwoak
         *
         * Problems Solved:
         * - Jadi ainx tanggal 17 Maret 2025 mengalami masalah ketika mau bikin timetablenya secara semi deterministik, ternyata masalahnya itu terletak di lecture slot. Pastikan lecture slotnya itu tersedia, contoh kalo misalnya total dari course yang 3 sks itu ada 200 (($course->credit_hour == 3)->count()), maka lecture slot untuk 3 sks harus lebih dari itu (antara ruangan/time slot yang diperbanyak, karena hari ga mungkin).
         */

        $populationSize = 3;
        $population = $this->initializePopulation($populationSize, true);

        $filteredPopulation = collect([]);
        // $conflicts = [];
        $conflictCounts = [];

        $mapChromosome = fn(array $value, int $key) =>
        [
            'id' => $key,
            'lecture' => [
                'course_name' => $value['lecture']->course->course_name,
                'class' => $value['lecture']->class,
                'lecturer_name' => $value['lecture']->lecturer->lecturer_name,
            ],
            'lecture_slot' => [
                'lecture_slot_id' => $value['lecture_slot']->id,
                'day' => $value['lecture_slot']->day->day,
                'time_slot' => [
                    'start_at' => $value['lecture_slot']->timeSlot->start_at,
                    'end_at' => $value['lecture_slot']->timeSlot->end_at
                ],
                'room_class' => $value['lecture_slot']->roomClass->room_class,
            ],
        ];

        for ($i = 0; $i < $populationSize; $i++) {
            $conflictCounts[] = 0;
            // $filteredPopulation[$i] = $population[$i]->filter(
            //     fn(array $value, int $key) =>
            //     $value['lecture']['course']['credit_hour'] == 2
            // )->values();
            $filteredPopulation[] = $population[$i]->map($mapChromosome);
            $chromosomeLength = count($filteredPopulation[$i]);
            $conflictCounts[$i] = $this->evaluateChromosome($filteredPopulation[$i]);
            $filteredPopulation[$i][] = ['fitness_score' => $chromosomeLength / ($chromosomeLength + $conflictCounts[$i])];
        }

        $bestChromosome = $this->chromosomeSelection($filteredPopulation);

        // $formattedData = collect([]);

        // for ($i = 0; $i < $populationSize; $i++) {
        //     $cromosomeLength = count($filteredPopulation[$i]);
        //     $formattedData->push([
        //         'chromosome_length' => $cromosomeLength,
        //         'conflict_count' => $conflictCounts[$i],
        //         'fitness_score' => $cromosomeLength / ($cromosomeLength + $conflictCounts[$i]),
        //     ]);
        // }

        return response()->json([
            'message' => 'Successful',
            'population_size' => $populationSize,
            'population' => $filteredPopulation,
        ]);
    }

    private function initializeChromosome(bool $modelResource = false)
    {
        $lectures =  LectureResource::collection(Lecture::all());
        [$twoCreditLectureSlots, $threeCreditLectureSlots] = $this->splitLectureSlotsByCreditHour();
        $lecturesCount = $lectures->count();
        $timetable = [];

        for ($i = 0; $i < $lecturesCount; $i++) {
            $data = fn(LectureSlotResource $slot) => $modelResource ? [
                'lecture' => new LectureResource($lectures[$i]),
                'lecture_slot' => new LectureSlotResource($slot),
            ] : [
                'lecture_id' => $lectures[$i]->id,
                'lecture_slot_id' => $slot->id,
            ];
            $isTwoCredit = $lectures[$i]->course->credit_hour === 2;

            /// Delete when added
            // $timetable[] = $isTwoCredit ?
            //     $data($twoCreditLectureSlots->pull($twoCreditLectureSlots->keys()->random())) :
            //     $data($threeCreditLectureSlots->pull($threeCreditLectureSlots->keys()->random()));

            /// Randomized lecture slot without delete
            $timetable[] = $isTwoCredit ?
                $data($twoCreditLectureSlots->random()) :
                $data($threeCreditLectureSlots->random());
        }

        return collect($timetable);
    }

    private function initializePopulation(int $populationSize, bool $modelResource = false): array
    {
        $population = [];

        for ($i = 0; $i < $populationSize; $i++) {
            $population[] = $this->initializeChromosome($modelResource);
        }

        return $population;
    }

    private function evaluateChromosome(Collection $population)
    {
        $conflictCount = 0;

        foreach ($population as $key => $value) {
            $start_at_first = Carbon::parse($value['lecture_slot']['time_slot']['start_at']);
            $end_at_first = Carbon::parse($value['lecture_slot']['time_slot']['end_at']);

            foreach ($population as $k => $v) {
                $start_at_second = Carbon::parse($v['lecture_slot']['time_slot']['start_at']);
                $end_at_second = Carbon::parse($v['lecture_slot']['time_slot']['end_at']);
                $isSameRoomClass = $value['lecture_slot']['room_class'] == $v['lecture_slot']['room_class'];
                $isSameDay = $value['lecture_slot']['day'] == $v['lecture_slot']['day'];
                $isSameLecture = $key == $k;

                if ($isSameLecture) continue;

                if ($isSameRoomClass && $isSameDay) {
                    if ($start_at_first < $end_at_second && $end_at_first > $start_at_second) {
                        $conflictCount++;
                    }
                }
            }
        }

        return $conflictCount / 2;
    }

    private function chromosomeSelection(Collection $population): array
    {
        $sort = $population->sortByDesc(fn(Collection $chromosome, int $key) =>
        $chromosome->last()['fitness_score'])->values();

        return [$sort[0], $sort[1]];
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
