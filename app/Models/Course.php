<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'course_name',
        'credit_hour',
        'is_has_practicum',
    ];

    protected function creditHour(): Attribute
    {
        return Attribute::make(
            get: fn(int $value) => $this->is_has_practicum ? $value - 1 : $value,
        );
    }

    public function lectures(): HasMany
    {
        return $this->hasMany(Lecture::class);
    }
}
