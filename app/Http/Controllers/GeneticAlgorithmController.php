<?php

namespace App\Http\Controllers;

use App\Http\Resources\LectureResource;
use App\Http\Resources\LectureSlotResource;
use App\Models\Lecture;
use App\Models\LecturerConstraint;
use App\Models\LectureSlot;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * PR BROWW:
 * - konfliknya diitung 2x, padahal sama hanya tertukar posisi index saja, e.g.: ada di excel -> sementara dibagi 2 dulu, awoakwoak
 *
 * Problems Solved:
 * - Jadi ainx tanggal 17 Maret 2025 mengalami masalah ketika mau bikin timetablenya secara semi deterministik, ternyata masalahnya itu terletak di lecture slot. Pastikan lecture slotnya itu tersedia, contoh kalo misalnya total dari course yang 3 sks itu ada 200 (($course->credit_hour == 3)->count()), maka lecture slot untuk 3 sks harus lebih dari itu (antara ruangan/time slot yang diperbanyak, karena hari ga mungkin).
 * - 17 April 2025 terjadi logic error di bagian mutasi, yang dimutasi malah populasi itu sendiri bukan offspringnya, gblk udh mikir mau ganti metode malah ternyata masalah salah assign variabel aja
 * 
 * Metode seleksi
 * 1. Elitisme:
 * - Keragaman kromosom akan terbatas karena yang diseleksi pasti dengan nilai fitness terbesar
 * 
 * 2. Turnamen
 * 
 * 3. Rolet Putar
 * 
 */

class GeneticAlgorithmController extends Controller
{
    public function generate(int $populationSize = 5, int $maxGeneration = 1, float $mutationRate = .2)
    {
        $startTime = microtime(true);

        $population = $this->initializePopulation($populationSize);
        $chromosomeLength = $population[0]['chromosome']->count();
        $lectureSlots = LectureSlot::all();
        $constrainedLecturers = LecturerConstraint::all();
        $constrainedLecturerIds = $constrainedLecturers
            ->unique('lecturer_id')
            ->map(fn($item) => $item['lecturer_id'])
            ->values();

        for ($generation = 0; $generation < $maxGeneration; $generation++) {
            for ($i = 0; $i < $populationSize; $i++) {
                $hardViolations = $this->evaluateChromosome($population[$i]['chromosome']->values());
                $softViolations = $this->evaluateSoftConstraints(
                    $constrainedLecturers,
                    $constrainedLecturerIds,
                    $population[$i]['chromosome']
                );

                $population[$i]
                    ->put('hard_violations', $hardViolations)
                    ->put('soft_violations', $softViolations)
                    ->put('fitness_score', $chromosomeLength / ($chromosomeLength + $hardViolations));
            }

            $bestChromosome = $this->chromosomeSelection($population->values());
            $offsprings = $this->chromosomeCrossover($bestChromosome->values());
            $mutatedOffsprings = $this->mutateChromosome(
                $lectureSlots,
                $offsprings->values(),
                $mutationRate,
            );

            for ($i = 0; $i < $mutatedOffsprings->count(); $i++) {
                $hardViolations = $this->evaluateChromosome($mutatedOffsprings[$i]['chromosome']->values());
                $softViolations = $this->evaluateSoftConstraints(
                    $constrainedLecturers,
                    $constrainedLecturerIds,
                    $mutatedOffsprings[$i]['chromosome']
                );
                $mutatedOffsprings[$i]
                    ->put('hard_violations', $hardViolations)
                    ->put('soft_violations', $softViolations)
                    ->put('fitness_score', $chromosomeLength / ($chromosomeLength + $hardViolations));
            }

            $population = $this->regeneration($population->values(), $mutatedOffsprings->values());
        }

        $endTime = microtime(true);

        return [
            'population' => $population->first(),
            'execution_times' => $endTime - $startTime,
        ];
    }

    private function initializeChromosome(): Collection
    {
        [$twoCreditLectureSlots, $threeCreditLectureSlots] = $this->splitLectureSlotsByCreditHour();
        $lectures = LectureResource::collection(Lecture::all());
        $lecturesCount = $lectures->count();
        $timetable = collect([]);

        for ($i = 0; $i < $lecturesCount; $i++) {
            $data = fn(LectureSlotResource $slot) => [
                'lecture' => new LectureResource($lectures[$i]),
                'lecture_slot' => new LectureSlotResource($slot),
            ];
            $isTwoCredit = $lectures[$i]->course->credit_hour === 2;

            $timetable->push($isTwoCredit ?
                $data($twoCreditLectureSlots->random()) :
                $data($threeCreditLectureSlots->random()));
        }

        return $timetable;
    }

    private function initializePopulation(int $populationSize): Collection
    {
        $population = collect([]);

        for ($i = 0; $i < $populationSize; $i++) {
            $chromosome = $this->initializeChromosome();
            $mappedChromosome = $this->mapChromosome($chromosome->values());
            $population->push(collect([])->put('chromosome', $mappedChromosome));
        }

        return $population;
    }

    private function evaluateChromosome(Collection $chromosome): int
    {
        $hardConstraintsViolationCount = 0;

        for ($i = 0; $i < $chromosome->count(); $i++) {
            $startAtFirst = Carbon::parse($chromosome[$i]['lecture_slot']['time_slot']['start_at']);
            $endAtFirst = Carbon::parse($chromosome[$i]['lecture_slot']['time_slot']['end_at']);


            for ($j = $i + 1; $j < $chromosome->count(); $j++) {
                $startAtSecond = Carbon::parse($chromosome[$j]['lecture_slot']['time_slot']['start_at']);
                $endAtSecond = Carbon::parse($chromosome[$j]['lecture_slot']['time_slot']['end_at']);
                $isSameRoomClass = $chromosome[$i]['lecture_slot']['room_class'] == $chromosome[$j]['lecture_slot']['room_class'];
                $isSameDay = $chromosome[$i]['lecture_slot']['day'] == $chromosome[$j]['lecture_slot']['day'];

                // $isSameLecture = $key == $k;

                // if ($isSameLecture) continue;

                if ($isSameRoomClass && $isSameDay) {
                    if ($startAtFirst < $endAtSecond && $endAtFirst > $startAtSecond) {
                        $hardConstraintsViolationCount++;
                    }
                }
            }
        }

        return $hardConstraintsViolationCount;

        // foreach ($population as $key => $value) {
        //     $start_at_first = Carbon::parse($value['lecture_slot']['time_slot']['start_at']);
        //     $end_at_first = Carbon::parse($value['lecture_slot']['time_slot']['end_at']);

        //     foreach ($population as $k => $v) {
        //         $start_at_second = Carbon::parse($v['lecture_slot']['time_slot']['start_at']);
        //         $end_at_second = Carbon::parse($v['lecture_slot']['time_slot']['end_at']);
        //         $isSameRoomClass = $value['lecture_slot']['room_class'] == $v['lecture_slot']['room_class'];
        //         $isSameDay = $value['lecture_slot']['day'] == $v['lecture_slot']['day'];
        //         $isSameLecture = $key == $k;

        //         if ($isSameLecture) continue;

        //         if ($isSameRoomClass && $isSameDay) {
        //             if ($start_at_first < $end_at_second && $end_at_first > $start_at_second) {
        //                 $hardConstraintsViolationCount++;
        //             }
        //         }
        //     }
        // }

        // return $hardConstraintsViolationCount / 2;
    }

    // Only Day, need to be improved with time
    private function evaluateSoftConstraints(Collection $constrainedLecturers, Collection $constrainedLecturerIds, Collection $chromosome): int
    {
        $softViolations = 0;

        foreach ($constrainedLecturerIds as $lecturerId) {
            $lectureSlots = $chromosome
                ->filter(fn($item) => $item['lecture']['lecturer']['id'] == $lecturerId)
                ->values();
            $lecturerConstraints = $constrainedLecturers
                ->where('lecturer_id', $lecturerId)
                ->values();

            for ($j = 0; $j < $lectureSlots->count(); $j++) {
                if ($lectureSlots[$j]['lecture_slot']['day']['id'] == $lecturerConstraints[$j]['day_id']) {
                    $softViolations++;
                }
            }
        }

        return $softViolations;
    }

    private function chromosomeSelection(Collection $population): Collection
    {
        $sort = $population->sortByDesc('fitness_score')->values();

        return collect([$sort[0], $sort[1]]);
    }

    private function chromosomeCrossover(Collection $bestChromosome): Collection
    {
        $firstChromosome = $bestChromosome[0]['chromosome']->values();
        $secondChromosome = $bestChromosome[1]['chromosome']->values();
        $chromosomeLength = $firstChromosome->count();

        $crossoverPoint = (int) ($chromosomeLength / 2);
        $halfFirstChromosome = $firstChromosome->splice($crossoverPoint);
        $halfSecondChromosome = $secondChromosome->splice($crossoverPoint);

        $offsprings = collect([])
            ->push(collect([])
                ->put('chromosome', collect([...$firstChromosome, ...$halfSecondChromosome])))
            ->push(collect([])
                ->put('chromosome', collect([...$secondChromosome, ...$halfFirstChromosome])));

        return $offsprings;
    }

    private function mutateChromosome(Collection $lectureSlots, Collection $offsprings, float $mutationRate = 0.2): Collection
    {
        $mutatedOffsprings = collect([]);

        foreach ($offsprings as $offspring) {
            $randomNumber = $this->getRandomNumber();
            $arrOffspring = $offspring->toArray();

            if ($randomNumber < $mutationRate) {
                $randomIndex = rand(0, $offspring['chromosome']->count() - 1);
                $randomLectureSlot = $lectureSlots->random();
                $arrOffspring['chromosome'][$randomIndex]['lecture_slot']['id'] = $randomLectureSlot->id;
                $arrOffspring['chromosome'][$randomIndex]['lecture_slot']['day']['id'] = $randomLectureSlot->day->id;
                $arrOffspring['chromosome'][$randomIndex]['lecture_slot']['day']['day'] = $randomLectureSlot->day->day;
                $arrOffspring['chromosome'][$randomIndex]['lecture_slot']['time_slot']['id'] = $randomLectureSlot->timeSlot->id;
                $arrOffspring['chromosome'][$randomIndex]['lecture_slot']['time_slot']['time_slot'] = $randomLectureSlot->timeSlot->time_slot;
                $arrOffspring['chromosome'][$randomIndex]['lecture_slot']['time_slot']['start_at'] = $randomLectureSlot->timeSlot->start_at;
                $arrOffspring['chromosome'][$randomIndex]['lecture_slot']['time_slot']['end_at'] = $randomLectureSlot->timeSlot->end_at;
                $arrOffspring['chromosome'][$randomIndex]['lecture_slot']['time_slot']['credit_hour'] = $randomLectureSlot->timeSlot->credit_hour;
                $arrOffspring['chromosome'][$randomIndex]['lecture_slot']['room_class']['id'] = $randomLectureSlot->roomClass->id;
                $arrOffspring['chromosome'][$randomIndex]['lecture_slot']['room_class']['room_class'] = $randomLectureSlot->roomClass->room_class;
            }

            $mutatedOffsprings->push($arrOffspring);
        }

        return $mutatedOffsprings->map(fn($item) => collect(['chromosome' => collect($item['chromosome'])]))->values();
    }

    private function regeneration(Collection $population, Collection $mutatedOffsprings): Collection
    {
        $population
            ->push($mutatedOffsprings[0])
            ->push($mutatedOffsprings[1]);
        $sorted = $population->sortByDesc('fitness_score')->values();
        $sorted->pop(2);


        return collect($sorted->all());
    }

    private function splitLectureSlotsByCreditHour(): array
    {
        $isTwoCreditHour = fn(JsonResource $item) => $item->timeSlot->credit_hour === 2;
        $isThreeCreditHour = fn(JsonResource $item) => $item->timeSlot->credit_hour === 3;
        $lectureSlots = LectureSlotResource::collection(LectureSlot::all());

        $twoCreditLectureSlots = collect($lectureSlots)->filter($isTwoCreditHour)->values();
        $threeCreditLectureSlots = collect($lectureSlots)->filter($isThreeCreditHour)->values();

        return [$twoCreditLectureSlots, $threeCreditLectureSlots];
    }

    private function mapChromosome(Collection $chromosome, int $filterCreditHour = 0): Collection
    {
        $mapChromosome = fn(array $value, int $key) =>
        [
            'id' => $key,
            'lecture' => [
                'id' => $value['lecture']->id,
                'course' => $value['lecture']->course,
                'class' => $value['lecture']->class,
                'lecturer' => $value['lecture']->lecturer,
            ],
            'lecture_slot' => [
                'id' => $value['lecture_slot']->id,
                'day' => $value['lecture_slot']->day,
                'time_slot' => $value['lecture_slot']->timeSlot,
                'room_class' => $value['lecture_slot']->roomClass,
            ],
        ];
        $filterTwoCreditScoreCourse = fn(array $item) => $item['lecture']['course']['credit_hour'] === 2;
        $filterThreeCreditScoreCourse = fn(array $item) => $item['lecture']['course']['credit_hour'] === 3;

        return match ($filterCreditHour) {
            0 => $chromosome->map($mapChromosome)->values(),
            2 => $chromosome->map($mapChromosome)->filter($filterTwoCreditScoreCourse)->values(),
            3 => $chromosome->map($mapChromosome)->filter($filterThreeCreditScoreCourse)->values(),
        };
    }

    private function getRandomNumber(): float
    {
        return mt_rand() / mt_getrandmax();
    }
}
