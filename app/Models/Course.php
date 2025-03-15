<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    public function lectures(): HasMany
    {
        return $this->hasMany(Lecture::class);
    }
}
