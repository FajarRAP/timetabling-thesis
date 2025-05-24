<?php

namespace App\Jobs;

use App\Models\Timetable;
use App\Models\TimetableEntry;
use App\Supports\GeneticAlgorithm;
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
    }
}
