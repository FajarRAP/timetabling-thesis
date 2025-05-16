<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimetableUsedConstraint extends Model
{
    protected $guarded = [];

    public function timetable()
    {
        return $this->belongsTo(Timetable::class);
    }

    public function lecturerConstraint()
    {
        return $this->belongsTo(LecturerConstraint::class);
    }

    public function lectureSlotConstraint()
    {
        return $this->belongsTo(LectureSlotConstraint::class);
    }
}
