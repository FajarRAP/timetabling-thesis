<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lecturer extends Model
{
    protected $fillable = [
        'lecturer_number',
        'lecturer_name',
    ];

    public function lectures(): HasMany
    {
        return $this->hasMany(Lecture::class);
    }
}
