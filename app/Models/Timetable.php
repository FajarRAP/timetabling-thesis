<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $fillable = [
        'fitness_score',
        'max_generation',
        'population_size',
        'mutation_rate',
        'execution_times',
    ];

    public function timetableUsedConstraints()
    {
        return $this->hasMany(TimetableUsedConstraint::class);
    }
}
