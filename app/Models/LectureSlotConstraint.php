<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LectureSlotConstraint extends Model
{
    protected $fillable = [
        'day_id',
        'start_at',
        'end_at',
    ];
    public function day(): BelongsTo
    {
        return $this->belongsTo(Day::class);
    }
}
