<?php

namespace App\Jobs;

use App\Models\Timetable;
use App\Models\TimetableEntry;
use App\Supports\GeneticAlgorithm;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateTimetable implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $params,
        public Timetable $timetable,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $ga = new GeneticAlgorithm(
            $this->params['population_size'],
            $this->params['max_generation'],
            $this->params['mutation_rate'],
        );
        $result = $ga->generate();

        $fitnessScore = $result['population']['fitness_score'];
        $chromosome = collect($result['population']['chromosome']);
        $executionTimes = $result['execution_times'];
        $hardViolations = $result['population']['hard_violations'];
        $softViolations = $result['population']['soft_violations'];
        $stoppedAtGeneration = $result['population']['stopped_at_generation'];

        $mappedChromosome = $chromosome->map(fn(array $item) => [
            'timetable_id' => $this->timetable->id,
            'lecture_id' => $item['lecture']['id'],
            'lecture_slot_id' => $item['lecture_slot']['id'],
        ])->values();

        $this->timetable->fitness_score = $fitnessScore;
        $this->timetable->max_generation = $this->params['max_generation'];
        $this->timetable->population_size = $this->params['population_size'];
        $this->timetable->mutation_rate = $this->params['mutation_rate'];
        $this->timetable->execution_times = $executionTimes;
        $this->timetable->hard_violations = $hardViolations;
        $this->timetable->soft_violations = $softViolations;
        $this->timetable->stopped_at_generation = $stoppedAtGeneration;
        $this->timetable->save();

        $mappedChromosome->each(fn(array $item) => TimetableEntry::create($item));
        $this->checkViolations();
    }

    private function checkViolations(): bool
    {
        $entries = $this->timetable->entries;

        for ($i = 0; $i < $entries->count(); $i++) {
            $startAtFirst = Carbon::parse($entries[$i]->lectureSlot->timeSlot->start_at);
            $endAtFirst = Carbon::parse($entries[$i]->lectureSlot->timeSlot->end_at);

            for ($j = $i + 1; $j < $entries->count(); $j++) {
                $startAtSecond = Carbon::parse($entries[$j]->lectureSlot->timeSlot->start_at);
                $endAtSecond = Carbon::parse($entries[$j]->lectureSlot->timeSlot->end_at);
                $isSameRoomClass = $entries[$i]->lectureSlot->roomClass->id == $entries[$j]->lectureSlot->roomClass->id;
                $isSameDay = $entries[$i]->lectureSlot->day->id == $entries[$j]->lectureSlot->day->id;
                $isOnlineClass = $entries[$i]->lectureSlot->roomClass->id == 1;
                $isCertainLecturer = $entries[$i]->lecture->lecturer->id < 34;
                $isSameLecturer = $entries[$i]->lecture->lecturer->id == $entries[$j]->lecture->lecturer->id;

                // Bentrok ruang kelas (room class) dan waktu (time slot)
                // Kelas online tidak ada bentrok ruangan
                if (!$isOnlineClass && $isSameRoomClass && $isSameDay) {
                    if ($startAtFirst < $endAtSecond && $endAtFirst > $startAtSecond) {
                        $entries[$i]->is_hard_violated = true;
                        $entries[$i]->save();
                        $entries[$j]->is_hard_violated = true;
                        $entries[$j]->save();
                    }
                }

                // Bentrok dosen (lecturer) dan waktu (time slot)
                // Ada dosen (lecturer) yang tidak tentu, yaitu LPSI (id 34) dan LPP (id 35)
                if ($isCertainLecturer && $isSameLecturer && $isSameDay) {
                    if ($startAtFirst < $endAtSecond && $endAtFirst > $startAtSecond) {
                        $entries[$i]->is_hard_violated = true;
                        $entries[$i]->save();
                        $entries[$j]->is_hard_violated = true;
                        $entries[$j]->save();
                    }
                }
            }
        }

        return $this->timetable->save();
    }
}
