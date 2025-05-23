<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LecturerConstraint extends Model
{
    protected $fillable = [
        'lecturer_id',
        'lecture_id',
        'day_id',
        'start_at',
        'end_at',
    ];

    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function lecture(): BelongsTo
    {
        return $this->belongsTo(Lecture::class);
    }

    public function day(): BelongsTo
    {
        return $this->belongsTo(Day::class);
    }

    public function timetableUsedConstraint()
    {
        return $this->hasMany(TimetableUsedConstraint::class);
    }
}
