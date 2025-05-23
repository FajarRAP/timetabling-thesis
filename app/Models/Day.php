<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Day extends Model
{
    public function twoCreditHourLectureSlot(): HasMany
    {
        return $this->hasMany(TwoCreditHourLectureSlot::class);
    }
}
