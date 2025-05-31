<?php

namespace App\Supports;

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
 * - konfliknya diitung 2x, padahal sama hanya tertukar posisi index saja, e.g.: ada di excel -> sementara dibagi 2 dulu, awoakwoak -> solved
 * 
 * Definisi Bentrok:
 * - Matakuliah: Ada matakuliah (course) yang bentrok dengan matakuliah (course) lain pada ruang kelas (room class) dan waktu (time slot) yang sama. Contoh: Matakuliah A di ruang kelas 1 pada jam 8-10, dan matakuliah B di ruang kelas 1 pada jam 8-10 juga
 * - Dosen: Ada dosen (lecturer) yang bentrok dengan dirinya sendiri pada ruang kelas (room class) berbeda, namun waktu yang sama. Contoh: Dosen A mengajar matakuliah A di ruang kelas 1 pada jam 8-10, dan mengajar matakuliah B di ruang kelas 2 pada jam 8-10 juga 
 * 
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

class GeneticAlgorithm
{
    private Collection $lectureSlots;
    private Collection $lectures;
    private Collection $constrainedLecturers;
    private Collection $onlineTwoCreditLectureSlots;
    private Collection $onlineThreeCreditLectureSlots;
    private Collection $offlineTwoCreditLectureSlots;
    private Collection $offlineThreeCreditLectureSlots;

    public function __construct(
        public int $populationSize = 5,
        public int $maxGeneration = 1,
        public float $mutationRate = .2,
    ) {
        $this->lectureSlots = LectureSlot::whereNull('lecture_slot_constraint_id')->get();
        $this->lectures = Lecture::all();
        $this->constrainedLecturers = LecturerConstraint::all();
        [
            $this->onlineTwoCreditLectureSlots,
            $this->onlineThreeCreditLectureSlots,
            $this->offlineTwoCreditLectureSlots,
            $this->offlineThreeCreditLectureSlots
        ] = $this->splitLectureSlots(LectureSlotResource::collection($this->lectureSlots)->values());
    }

    public function generate()
    {
        set_time_limit(36000);

        $startTime = microtime(true);

        $population = $this->initializePopulation();
        $chromosomeLength = $population[0]['chromosome']->count();

        $constrainedLecturerIds = $this->constrainedLecturers
            ->unique('lecturer_id')
            ->map(fn($item) => $item['lecturer_id'])
            ->values();

        for ($generation = 0; $generation < $this->maxGeneration; $generation++) {
            for ($i = 0; $i < $this->populationSize; $i++) {
                $hardViolations = $this->evaluateChromosome($population[$i]['chromosome']->values());
                $softViolations = $this->evaluateSoftConstraints(
                    $constrainedLecturerIds,
                    $population[$i]['chromosome']->values(),
                );

                $population[$i]
                    ->put('hard_violations', $hardViolations)
                    ->put('soft_violations', (float) $softViolations / 2)
                    ->put('fitness_score', $chromosomeLength / ($chromosomeLength + $hardViolations + $softViolations));
            }

            $bestChromosome = $this->chromosomeSelection($population->values());
            $offsprings = $this->chromosomeCrossover($bestChromosome->values());
            $mutatedOffsprings = $this->mutateChromosome($offsprings->values());

            for ($i = 0; $i < $mutatedOffsprings->count(); $i++) {
                $hardViolations = $this->evaluateChromosome($mutatedOffsprings[$i]['chromosome']->values());
                $softViolations = $this->evaluateSoftConstraints(
                    $constrainedLecturerIds,
                    $mutatedOffsprings[$i]['chromosome']->values(),
                );
                $mutatedOffsprings[$i]
                    ->put('hard_violations', $hardViolations)
                    ->put('soft_violations', (float) $softViolations / 2)
                    ->put('fitness_score', $chromosomeLength / ($chromosomeLength + $hardViolations + $softViolations));
            }

            $population = $this->regeneration(
                $population->values(),
                $mutatedOffsprings->values(),
            );

            if ($population->first()['hard_violations'] < 10) {
                return [
                    'population' => $population->first()->put('stopped_at_generation', $generation),
                    'execution_times' => microtime(true) - $startTime,
                ];
            }
        }

        $endTime = microtime(true);

        return [
            'population' => $population->first()->put('stopped_at_generation', $generation),
            'execution_times' => $endTime - $startTime,
        ];
    }

    private function initializeChromosome(): Collection
    {
        $lecturesCount = $this->lectures->count();
        $timetable = collect([]);

        for ($i = 0; $i < $lecturesCount; $i++) {
            $data = fn(LectureSlotResource $slot) => [
                'lecture' => new LectureResource($this->lectures[$i]),
                'lecture_slot' => new LectureSlotResource($slot),
            ];
            $isTwoCredit = $this->lectures[$i]->course->credit_hour === 2;
            $isOnline = $this->lectures[$i]->course->is_online;

            $timetable->push($isOnline ?
                ($isTwoCredit ? $data($this->onlineTwoCreditLectureSlots->random()) : $data($this->onlineThreeCreditLectureSlots->random())) : ($isTwoCredit ? $data($this->offlineTwoCreditLectureSlots->random()) : $data($this->offlineThreeCreditLectureSlots->random())));
        }

        return $timetable;
    }

    private function initializePopulation(): Collection
    {
        $population = collect([]);

        for ($i = 0; $i < $this->populationSize; $i++) {
            $chromosome = $this->initializeChromosome();
            $mappedChromosome = $this->mapChromosome($chromosome->values());
            $population->push(collect([])->put('chromosome', $mappedChromosome));
            $population[$i]
                ->put('hard_violations', 0)
                ->put('soft_violations', 0)
                ->put('fitness_score', 0);
        }

        return $population;
    }

    private function evaluateChromosome(Collection $chromosome): int
    {
        $hardViolations = 0;

        for ($i = 0; $i < $chromosome->count(); $i++) {
            $startAtFirst = Carbon::parse($chromosome[$i]['lecture_slot']['time_slot']['start_at']);
            $endAtFirst = Carbon::parse($chromosome[$i]['lecture_slot']['time_slot']['end_at']);


            for ($j = $i + 1; $j < $chromosome->count(); $j++) {
                $startAtSecond = Carbon::parse($chromosome[$j]['lecture_slot']['time_slot']['start_at']);
                $endAtSecond = Carbon::parse($chromosome[$j]['lecture_slot']['time_slot']['end_at']);
                $isSameRoomClass = $chromosome[$i]['lecture_slot']['room_class']['id'] == $chromosome[$j]['lecture_slot']['room_class']['id'];
                $isOnlineClass = $chromosome[$i]['lecture_slot']['room_class']['id'] == 1;
                $isCertainLecturer = $chromosome[$i]['lecture']['lecturer']['id'] != 34 && $chromosome[$i]['lecture']['lecturer']['id'] != 35;
                $isSameDay = $chromosome[$i]['lecture_slot']['day']['id'] == $chromosome[$j]['lecture_slot']['day']['id'];
                $isSameLecturer = $chromosome[$i]['lecture']['lecturer']['id'] == $chromosome[$j]['lecture']['lecturer']['id'];

                // += 2 karena bentrok ini dihitung 2x, yaitu i dan j
                // Bentrok ruang kelas (room class) dan waktu (time slot)
                // Kelas online tidak ada bentrok ruangan
                if (!$isOnlineClass && $isSameRoomClass && $isSameDay) {
                    if ($startAtFirst < $endAtSecond && $endAtFirst > $startAtSecond) {
                        $hardViolations += 2;
                    }
                }

                // Bentrok dosen (lecturer) dan waktu (time slot)
                // Ada dosen (lecturer) yang tidak tentu, yaitu LPSI (id 34) dan LPP (id 35)
                if ($isCertainLecturer && $isSameLecturer && $isSameDay) {
                    if ($startAtFirst < $endAtSecond && $endAtFirst > $startAtSecond) {
                        $hardViolations += 2;
                    }
                }
            }
        }

        return $hardViolations;
    }

    private function evaluateSoftConstraints(Collection $constrainedLecturerIds, Collection $chromosome): int
    {
        $softViolations = 0;

        foreach ($constrainedLecturerIds as $lecturerId) {
            $lectureSlots = $chromosome
                ->filter(fn($item) => $item['lecture']['lecturer']['id'] == $lecturerId)
                ->values();
            $lecturerConstraints = $this->constrainedLecturers
                ->where('lecturer_id', $lecturerId)
                ->values();

            for ($j = 0; $j < $lectureSlots->count(); $j++) {
                $lectureSlotDayId = $lectureSlots[$j]['lecture_slot']['day']['id'];
                $lectureSlotStartAt = Carbon::parse($lectureSlots[$j]['lecture_slot']['time_slot']['start_at']);
                $lectureSlotEndAt = Carbon::parse($lectureSlots[$j]['lecture_slot']['time_slot']['end_at']);
                $lecturerConstraintDayId = $lecturerConstraints[$j]['day_id'];
                $lecturerConstraintStartAt = Carbon::parse($lecturerConstraints[$j]['start_at']);
                $lecturerConstraintEndAt = Carbon::parse($lecturerConstraints[$j]['end_at']);

                // Pelanggaran preferensi dosen (lecturer) untuk hari (day)
                if ($lectureSlotDayId == $lecturerConstraintDayId) {
                    $softViolations++;
                }

                // Pelanggaran preferensi dosen (lecturer) untuk waktu perkuliahan dimulai (start at)
                if ($lectureSlotStartAt < $lecturerConstraintStartAt && $lecturerConstraints[$j]['start_at'] != null) {
                    $softViolations++;
                }

                // Pelanggaran preferensi dosen (lecturer) untuk batas akhir waktu perkuliahan (end at)
                if ($lectureSlotEndAt > $lecturerConstraintEndAt && $lecturerConstraints[$j]['end_at'] != null) {
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

    private function mutateChromosome(Collection $offsprings): Collection
    {
        $mutatedOffsprings = collect([]);

        foreach ($offsprings as $offspring) {
            $randomNumber = $this->getRandomNumber();
            $arrOffspring = $offspring->toArray();

            // Setiap gen diiterasi dan dimutasi jika random number kurang dari mutation rate
            // foreach ($arrOffspring['chromosome'] as $index => $gene) {
            //     if ($this->getRandomNumber() < $this->mutationRate) {
            //         $randomLectureSlot = $this->randomizedLectureSlot($gene);
            //         $arrOffspring['chromosome'][$index]['lecture_slot']['id'] = $randomLectureSlot->id;
            //         $arrOffspring['chromosome'][$index]['lecture_slot']['day']['id'] = $randomLectureSlot->day->id;
            //         $arrOffspring['chromosome'][$index]['lecture_slot']['time_slot']['id'] = $randomLectureSlot->timeSlot->id;
            //         $arrOffspring['chromosome'][$index]['lecture_slot']['time_slot']['credit_hour'] = $randomLectureSlot->timeSlot->credit_hour;
            //         $arrOffspring['chromosome'][$index]['lecture_slot']['time_slot']['start_at'] = $randomLectureSlot->timeSlot->start_at;
            //         $arrOffspring['chromosome'][$index]['lecture_slot']['time_slot']['end_at'] = $randomLectureSlot->timeSlot->end_at;
            //         $arrOffspring['chromosome'][$index]['lecture_slot']['room_class']['id'] = $randomLectureSlot->roomClass->id;
            //     }
            // }

            // Hanya mengambil 1 gen dari kromosom
            if ($randomNumber < $this->mutationRate) {
                $randomIndex = rand(0, $offspring['chromosome']->count() - 1);
                $randomLectureSlot = $this->randomizedLectureSlot($arrOffspring['chromosome'][$randomIndex]);

                $arrOffspring['chromosome'][$randomIndex]['lecture_slot']['id'] = $randomLectureSlot->id;
                $arrOffspring['chromosome'][$randomIndex]['lecture_slot']['day']['id'] = $randomLectureSlot->day->id;
                $arrOffspring['chromosome'][$randomIndex]['lecture_slot']['time_slot']['id'] = $randomLectureSlot->timeSlot->id;
                $arrOffspring['chromosome'][$randomIndex]['lecture_slot']['time_slot']['credit_hour'] = $randomLectureSlot->timeSlot->credit_hour;
                $arrOffspring['chromosome'][$randomIndex]['lecture_slot']['time_slot']['start_at'] = $randomLectureSlot->timeSlot->start_at;
                $arrOffspring['chromosome'][$randomIndex]['lecture_slot']['time_slot']['end_at'] = $randomLectureSlot->timeSlot->end_at;
                $arrOffspring['chromosome'][$randomIndex]['lecture_slot']['room_class']['id'] = $randomLectureSlot->roomClass->id;
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

    private function splitLectureSlots(Collection $lectureSlotResources): array
    {
        $isOnline = fn(JsonResource $item) => $item->roomClass->id === 1;
        $isOffline = fn(JsonResource $item) => $item->roomClass->id !== 1;
        $isTwoCreditHour = fn(JsonResource $item) => $item->timeSlot->credit_hour === 2;
        $isThreeCreditHour = fn(JsonResource $item) => $item->timeSlot->credit_hour === 3;

        $onlineLectureSlots = collect($lectureSlotResources)->filter($isOnline)->values();
        $onlineTwoCreditLectureSlots = collect($onlineLectureSlots)->filter($isTwoCreditHour)->values();
        $onlineThreeCreditLectureSlots = collect($onlineLectureSlots)->filter($isThreeCreditHour)->values();
        $offlineLectureSlots = collect($lectureSlotResources)->filter($isOffline)->values();
        $offlineTwoCreditLectureSlots = collect($offlineLectureSlots)->filter($isTwoCreditHour)->values();
        $offlineThreeCreditLectureSlots = collect($offlineLectureSlots)->filter($isThreeCreditHour)->values();

        return [$onlineTwoCreditLectureSlots, $onlineThreeCreditLectureSlots, $offlineTwoCreditLectureSlots, $offlineThreeCreditLectureSlots];
    }

    private function mapChromosome(Collection $chromosome, int $filterCreditHour = 0): Collection
    {
        $mapChromosome = fn(array $value, int $key) =>
        [
            'id' => $key,
            'lecture' => [
                'id' => $value['lecture']->id,
                'lecturer' => [
                    'id' => $value['lecture']->lecturer->id,
                ],
            ],
            'lecture_slot' => [
                'id' => $value['lecture_slot']->id,
                'day' => [
                    'id' => $value['lecture_slot']->day->id,
                ],
                'time_slot' => [
                    'id' => $value['lecture_slot']->timeSlot->id,
                    'credit_hour' => $value['lecture_slot']->timeSlot->credit_hour,
                    'start_at' => $value['lecture_slot']->timeSlot->start_at,
                    'end_at' => $value['lecture_slot']->timeSlot->end_at,
                ],
                'room_class' => [
                    'id' => $value['lecture_slot']->roomClass->id,
                ],
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

    private function randomizedLectureSlot(array $gene): LectureSlotResource
    {
        // Online Class
        if ($gene['lecture_slot']['room_class']['id'] === 1) {
            // 2 Credit Hour Time
            if ($gene['lecture_slot']['time_slot']['credit_hour'] === 2) {
                return $this->onlineTwoCreditLectureSlots->random();
            }
            // 3 Credit Hour Time
            else {
                return $this->onlineThreeCreditLectureSlots->random();
            }
        }
        // Offline class
        else {
            // 2 Credit Hour Time
            if ($gene['lecture_slot']['time_slot']['credit_hour'] === 2) {
                return $this->offlineTwoCreditLectureSlots->random();
            }
            // 3 Credit Hour Time
            else {
                return $this->offlineThreeCreditLectureSlots->random();
            }
        }
    }
}
