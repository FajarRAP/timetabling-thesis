<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LectureSlot extends Model
{
    protected $guarded = [];
    
    public function day(): BelongsTo
    {
        return $this->belongsTo(Day::class);
    }

    public function timeSlot(): BelongsTo
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function roomClass(): BelongsTo
    {
        return $this->belongsTo(RoomClass::class);
    }

    public function timetableUsedConstraint()
    {
        return $this->hasMany(TimetableUsedConstraint::class);
    }
}
